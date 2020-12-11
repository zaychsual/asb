<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceDetail;
use App\LogInvoice;
use App\Item;
use App\MstSupplier;
use Uuid;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(\Gate::allows('transaction_access'), 403);

        $trx = Invoice::all();
        // dd($transaction);
        return view('admin.invoice.index', compact('trx'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(\Gate::allows('transaction_create'), 403);
        $count = Invoice::count();
        $no = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        $no_trx = 'INV/'.date('d/m/y').'/'.$no;
        $supplier = MstSupplier::all()->pluck('nama', 'id');
        $item   = Item::all()->pluck('nama','id');

        return view('admin.invoice.create', compact('supplier','item','no_trx'));
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
     
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        \DB::beginTransaction();
        try {
            // dd($request);
            $uuid = Uuid::generate();

            $inv = Invoice::create([
                'id'    => $uuid,
                'no_transaksi'  => $request->no_trx, 
                'transaction_date'  => $request->tanggal_transaksi, 
                'type'  => $request->tipe, 
                'custid'  => $request->supplier_id,
                'subtotal'  => $this->clean($request->subtotal),
                'disc'  => $this->clean($request->disc),
                'ppn'  => $request->ppn,
                'grandtotal'  => $this->clean($request->total_amount),
                'created_by'  => \Auth::user()->id,
                'created_at'  => date('Y-m-d H:i:s'), 
            ]);

            if( $request->has('barang_id') ) {
                foreach( $request->barang_id as $key => $detail ) {
                    $dt_uuid = Uuid::generate();

                    $dt = InvoiceDetail::create([
                        'id'    => $dt_uuid,
                        'invoice_id'    => $uuid,
                        'product_id' => $request->barang_id[$key],
                        'qty'   => $request->qty[$key] ?? 0,
                        'price'   => $this->clean($request->price[$key] ?? 0),
                        'amount'   => $this->clean($request->amount[$key] ?? 0),
                        'created_by'   => \Auth::user()->id,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'status'  => 1,
                    ]);

                    $log = LogInvoice::insert([
                        'invoice_id' => $uuid,
                        'invoice_dt' => $dt_uuid,
                        'product_id' => $request->barang_id[$key],
                        'qty'   => $request->qty[$key] ?? 0,
                        'price'   => $this->clean($request->price[$key] ?? 0),
                        'amount'   => $this->clean($request->amount[$key] ?? 0),
                        'created_by'   => \Auth::user()->id,
                        'created_at'  => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
        return \redirect()->route('admin.invoice.index')->with('success',\trans('notif.notification.save_data.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inv = Invoice::find($id);
        $dt = InvoiceDetail::where('invoice_id', $id)
            ->get();
        
        return view('admin.invoice.show', compact('inv', 'dt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
