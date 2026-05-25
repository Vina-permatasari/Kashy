<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class KasirTransactionController extends Controller
{
    public function create()
    {
        $products = Product::select('id', 'nama_produk', 'harga', 'gambar', 'stok')->get();
        $members = Member::select('id', 'nama', 'no_hp')->get();

        return view('kasir.transaksi', compact('products', 'members'));
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20|unique:members,no_hp',
        ]);

        $member = Member::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return response()->json([
            'success' => true,
            'member' => $member
        ]);
    }

    public function pembayaran()
    {
        $transaction = session('kasir_transaction');

        if (!$transaction) {
            return redirect()
                ->route('kasir.transaksi')
                ->with('error', 'Keranjang masih kosong.');
        }

        return view('kasir.pembayaran', compact('transaction'));
    }

    public function saveTransactionSession(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'customer_name' => 'required|string',
            'member_id' => 'nullable',
            'discount_percent' => 'nullable|numeric',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        session([
            'kasir_transaction' => $request->all()
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('kasir.pembayaran')
        ]);
    }

    public function finalizePayment(Request $request)
    {
        
        // LOG 1: Cek request
        \Log::info('=== FINALIZE PAYMENT ===');
        \Log::info('Request data:', $request->all());
        
        $transactionData = session('kasir_transaction');

        // LOG 2: Cek session
        \Log::info('Session data:', $transactionData ?? ['SESSION KOSONG']);    

        if (!$transactionData) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }

        $invoice = 'INV-' . now()->format('YmdHis');
        $bayar = $request->bayar ?? $transactionData['total'];
        $kembalian = $request->kembalian ?? 0;

        try {
            $transaction = Transaction::create([
                'invoice_number' => $invoice,
                'kasir_id' => Auth::id(),
                'customer_name' => $transactionData['customer_name'] ?? 'Customer',
                'payment_method' => $request->payment_method,
                'metode_pembayaran' => $request->payment_method,
                'total' => $transactionData['subtotal'],
                'diskon' => 0,
                'discount_percent' => $transactionData['discount_percent'] ?? 0,
                'grand_total' => $transactionData['total'],
                'bayar' => $bayar,
                'kembalian' => $kembalian,
            ]);

            foreach ($transactionData['cart'] as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'qty' => $item['qty'],
                    'harga' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

                $product = Product::find($item['id']);
                if ($product) {
                    $product->stok -= $item['qty'];
                    if ($product->stok < 0) $product->stok = 0;
                    $product->save();
                }
            }

            session()->forget('kasir_transaction');

            return response()->json([
                'success' => true,
                'invoice' => $invoice
            ]);
            
        } catch (\Exception $e) {
            // LOG 4: Error detail
            \Log::error('Payment Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}