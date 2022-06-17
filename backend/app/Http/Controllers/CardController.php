<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Exception;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Card list
        $cards = Card::orderBy('order')->get()->toArray();
        return response()->json(['cards' => json_encode($cards)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Store Card
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'column_id' => 'required',
            ]);
            $lastOrder = !Card::first() ? 0 : Card::orderBy('order', 'DESC')->first()->order;
            $card = new Card();
            $card->name = $request->name;
            $card->description = $request->description;
            $card->column_id = $request->column_id;
            $card->order = $lastOrder + 1;
            $card->save();

            $cards = Card::orderBy('order')->get()->toArray();

            return response()->json(['statuscode' => 200, 'cards' => json_encode($cards)]);
        } catch (Exception $e) {
            return response()->json(['statuscode' => $e]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //Update Card data
        try {
            $card = Card::find($id);
            $card->update($request->all());

            $cards = Card::orderBy('order')->get()->toArray();

            return response()->json(['statuscode' => 200, 'cards' => json_encode($cards)]);
        } catch (Exception $e) {
            return response()->json(['statuscode' => $e]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Destory Card table
        try {
            Card::destroy($id);
            $cards = Card::orderBy('order')->get()->toArray();

            return response()->json(['statuscode' => 200, 'cards' => json_encode($cards)]);
        } catch (Exception $e) {
            return response()->json(['statuscode' => $e]);
        }
    }

    public function arrow(Request $request)
    {
        //Arrow Card table
        try {
            $column_id = $request->column;
            $card_id = $request->card;
            $arrow = $request->arrow;

            $cardindex = $request->cardindex;

            //If Arrow is up

            if ($arrow == 'up') {
                $cards = Card::orderBy('order')->where('column_id', $column_id)->get();
                foreach ($cards as $card => $value) {
                    if ($card == ($cardindex - 1)) {
                        $beforeCard = $value;
                    }
                }
                $indexOrder = Card::where('id', $card_id)->get('order')[0]->order;
                $targetOrder = $beforeCard->order;
                $targetId = $beforeCard->id;

                Card::where('id', $card_id)->update([
                    'order' => $targetOrder,
                ]);
                Card::where('id', $targetId)->update([
                    'order' => $indexOrder,
                ]);
            }

            //If Arrow is down

            elseif ($arrow == 'down') {
                $cards = Card::orderBy('order')->where('column_id', $column_id)->get();
                foreach ($cards as $card => $value) {
                    if ($card == ($cardindex + 1)) {
                        $afterCard = $value;
                    }
                }
                $indexOrder = Card::where('id', $card_id)->get('order')[0]->order;
                $targetOrder = $afterCard->order;
                $targetId = $afterCard->id;

                Card::where('id', $card_id)->update([
                    'order' => $targetOrder,
                ]);
                Card::where('id', $targetId)->update([
                    'order' => $indexOrder,
                ]);
            }

            //If Arrow is left

            elseif ($arrow == 'left') {
                $columnIndex = $request->columnindex;
                $columns = Column::orderBy('order')->get();
                foreach ($columns as $column => $value) {
                    if ($column == ($columnIndex - 1)) {
                        $afterColumn = $value;
                    }
                }

                $lastOrder = Card::orderBy('order', 'DESC')->first()->order;
                $targetId = $afterColumn->id;

                Card::where('id', $card_id)->update([
                    'column_id' => $targetId,
                    'order' => $lastOrder + 1,
                ]);
            }

            //If Arrow is right

            elseif ($arrow == 'right') {
                $columnIndex = $request->columnindex;
                $columns = Column::orderBy('order')->get();
                foreach ($columns as $column => $value) {
                    if ($column == ($columnIndex + 1)) {
                        $afterColumn = $value;
                    }
                }

                $lastOrder = Card::orderBy('order', 'DESC')->first()->order;
                $targetId = $afterColumn->id;

                Card::where('id', $card_id)->update([
                    'column_id' => $targetId,
                    'order' => $lastOrder + 1,
                ]);
            }

            $cards = Card::orderBy('order')->get()->toArray();
            $columns = Column::orderBy('order')->get()->toArray();

            return response()->json(['statuscode' => 200, 'cards' => json_encode($cards), 'columns' => json_encode($columns)]);

        } catch (Exception $e) {
            return response()->json(['statuscode' => 'error']);
        }
    }

}
