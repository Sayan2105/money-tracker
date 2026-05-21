<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    //

    public function index(Request $req){
        $expenses = $req->user()->expenses()
        ->when($req->category, function ($query) use ($req){
            $query->where('category', $req->category);
        })
        ->when($req->date, function ($query) use ($req){
            $query->where('date', $req->date);
        })
        ->paginate(10);

        return response()->json($expenses);
    }

    public function store(Request $req){
        $req->validate([
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'date' => 'required|date',
        ]);

        $expense = Expense::create([
            'title' => $req->title,
            'amount' => $req->amount,
            'category' => $req->category,
            'date' => $req->date,
            'user_id' => $req->user()->id
        ]);

        return response()->json($expense);

    }

    public function show(Request $req, $id){

        $expense = Expense::where('id', $id)->where('user_id', $req->user()->id)->firstOrFail();

        return response()->json($expense);
    }

    public function update(Request $req, $id){

        $req->validate([
            'amount'   => 'numeric',
            'date'     => 'date'
        ]);

        $expense = Expense::where('user_id', $req->user()->id)->where('id', $id)->firstOrFail();

        $expense->update($req->all());

        return response()->json($expense);
    }

    public function destroy(Request $req, $id){
        $expense = Expense::where('user_id', $req->user()->id)->where('id', $id)->firstOrFail();

        $expense->delete();

        return response()->json([
            'message' => 'Expense Deleted Successfully'
        ]);
    }

    public function adminIndex(Request $req){
        $expenses = Expense::with('user')
            ->when($req->category, function ($query) use ($req){
                $query->where('category', $req->category);
            })
            ->when($req->date, function ($query) use ($req){
                $query->where('date', $req->date);
            })
            ->when($req->query('user_id'), function ($query) use ($req){
                $query->where('user_id', $req->query('user_id'));
            })
            ->paginate(10);

        return response()->json($expenses);
    }
}
