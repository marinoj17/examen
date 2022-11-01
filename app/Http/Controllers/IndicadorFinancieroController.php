<?php

namespace App\Http\Controllers;

use App\Models\IndicadorFinanciero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class IndicadorFinancieroController extends Controller
{

    public function index()
    {
        $indicadores = IndicadorFinanciero::all();
        return view('content.indicadores_financieros.index', compact('indicadores'));
    }

    public function edit($id)
    {

        $data = IndicadorFinanciero::findOrFail($id);
        return response()->json(['data' => $data]);

    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [

            'nombreIndicador' => 'required',
            'codigoIndicador' => 'required',
            'unidadMedidaIndicador' => 'required',
            'valorIndicador' => 'required',
        ]);

        if ($v->fails()) {
            return Response::json([
                'success' => true,
                'message' => $v->errors(),
            ], 401);
        }
        $indicador = new IndicadorFinanciero();
        $indicador->create($request->all());

        return Response::json([
            'success' => true,
            'message' => 'Registro guardado con Éxito',
        ], 200);
    }
    /**
     * Display the specified resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $indicador = IndicadorFinanciero::findOrFail($id);
        $indicador->update($request->all());

        $indicador->save();
        return Response::json([
            'success' => true,
            'message' => 'Registro Actualizado con éxito',
        ], 200);
    }

    public function graph()
    {

        $listas = IndicadorFinanciero::select('codigoIndicador')->orderBy('codigoIndicador', 'desc')
            ->groupBy('codigoIndicador')
            ->get();
        return view('content.indicadores_financieros.graphic', compact('listas'));
    }

    public function getMeses(Request $request)
    {
      setlocale(LC_ALL, "spanish");
        $fecha_inicial = new \DateTime($request->gDesde);
        $fecha_final = new \DateTime($request->gHasta);

        $listas=IndicadorFinanciero::select('codigoIndicador','fechaIndicador','valorIndicador')
        ->whereBetween('fechaIndicador', [$fecha_inicial, $fecha_final])
        ->where('codigoIndicador',$request->codigoIndicador)
        ->get();
      $fecha=[];
      $valor=[];
      foreach ($listas as $lista) {
      $fecha[]=$lista->fechaIndicador;
      $valor[]=$lista->valorIndicador;
      }

      return Response::json([
        'success' => true,
        'result' => ['valor'=>$valor,'fecha'=>$fecha],
    ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        IndicadorFinanciero::destroy($request->id);

        return Response::json([
            'success' => true,
            'message' => 'Registro Eliminado con éxito',
        ], 200);
        // return ; DEBE DEVOLVER UN
    }
}
