<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Type;
use Illuminate\Http\Request;
use PHPUnit\Event\Tracer\Tracer;

use function PHPSTORM_META\type;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $transactions = Transaction::all();
        $income = Transaction::where('type_id', 1)->get();
        $expense = Transaction::where('type_id', 2)->get();

        // data chart income 
        $dataIncome = [];
        foreach ($income as $in) {
            if (array_key_exists($in->category->name, $dataIncome)) {
                $dataIncome[$in->category->name] = $dataIncome[$in->category->name] + $in->amount;
            } else {
                $dataIncome[$in->category->name] =  $in->amount;
            }
        }
        $dataIncome = [
            'label' => array_keys($dataIncome),
            'data' => array_values($dataIncome),
        ];


        // data chart income 
        $dataExpense = [];
        foreach ($expense as $ex) {
            if (array_key_exists($ex->category->name, $dataExpense)) {
                $dataExpense[$ex->category->name] = $dataExpense[$ex->category->name] + $ex->amount;
            } else {
                $dataExpense[$ex->category->name] =  $ex->amount;
            }
        }
        $dataExpense = [
            'label' => array_keys($dataExpense),
            'data' => array_values($dataExpense),
        ];


        // hitung total income
        $totalIncome = 0;
        foreach ($income as $in) {
            $totalIncome = $totalIncome + $in->amount;
        }

        // hitung total expense
        $totalExpense = 0;
        foreach ($expense as $ex) {
            $totalExpense = $totalExpense + $ex->amount;
        }

        $totalBalance = $totalIncome - $totalExpense;


        // return view('users', [ 'usersChart' => $usersChart ] );
        return view('home.index', [
            "title" => 'home',
            "transactions" => $transactions,
            "income" => $income,
            "expense" => $expense,
            "totalBalance" => $totalBalance,
            "dataIncome" => $dataIncome,
            "dataExpense" => $dataExpense,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Transaction::create([
            'amount' => $request->input('amount'),
            'type_id' => $request->input('type_id'),
            'category_id' => $request->input('category_id'),
            'date' => $request->input('date'),
        ]);
        return redirect('/')->with(['success' => 'Berhasil menambah data baru']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $transaction = Transaction::find($id);
        $transaction->delete();


        // Transaction::destroy();
        return redirect('/')->with('success', 'Berhasil menghapus data');
    }
}
