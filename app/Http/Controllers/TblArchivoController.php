<?php

namespace App\Http\Controllers;

use App\Models\tbl_archivo;
use App\Models\tbl_cliente;
use App\Models\tbl_tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use DB;
use Auth;
use File;
use Response;

class TblArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if($request->file('file')) {
            $image = $request->file('file');
            $imageName = Str::uuid(). '.' . $image->extension();
            $img = tbl_archivo::create(['tabla' => $request->tab, 'id_asociado' => $request->asoc, 'nombre' => $imageName, 'nombre_original' => $image->getClientOriginalName(), 'tamano' => $image->getSize(), 'tipo' => $image->extension(), 'id_tipo' => $request->id_tipo, 'direccion' => $request->pac.'/'.$imageName, 'id_usuario_reg' => auth()->user()->id, 'id_cat_folder_personal' => $request->car]);
            //$image->move(public_path('documentos'),$imageName);
            Storage::disk($request->pac)->put($imageName, file_get_contents($request->file('file')));
            \Notificaciones::agregarLog("Imagen ".$image->getClientOriginalName()." de la propiedad agregado", $img->id,"tbl_archivos"); //$request->id_lead_doc

            $archivos = tbl_archivo::where('id_asociado', $request->asoc)->where('id_cat_folder_personal', $request->car)->get();
            return response()->json(['respuesta' => true, 'archivos' => $archivos, 'car'=> $request->car]);
        }

        if($request->id_d){
            tbl_archivo::where('id','=',$request->id_d)->update($request->except(['id_d']));
            return response()->json(['respuesta' => "completado"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tbl_archivo  $tbl_archivo
     * @return \Illuminate\Http\Response
     */
    public function show(tbl_archivo $tbl_archivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tbl_archivo  $tbl_archivo
     * @return \Illuminate\Http\Response
     */
    public function edit(tbl_archivo $tbl_archivo,$id)
    {
        $nombre = tbl_cliente::where('id', '=', $id)->first();

        return response()->json([
            'status' => true,
            'documentos' => tbl_archivo::where('id_propiedad',"=",$id)->where('id_tipo', '=', 1)->get(),
            'nombre' => $nombre->nombre.' '.$nombre->apellido_paterno.' '.$nombre->apellido_materno
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tbl_archivo  $tbl_archivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tbl_archivo $tbl_archivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tbl_archivo  $tbl_archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(tbl_archivo $tbl_archivo,$id)
    {
        $archivo = tbl_archivo::find($id);
        $car = $archivo->id_cat_folder_personal;
        $documento = tbl_archivo::withTrashed()->find($id);
        $documento ->delete();

        \Notificaciones::agregarLog("Documento de la propiedad eliminado", $id ,"tbl_archivos");

        return response()->json([
            'respuesta' => true,
            'archivos' => tbl_archivo::where('id_asociado',$archivo->id_asociado)->where('id_cat_folder_personal', $car)->oldest()->get(),
        ], 200);
    }

    public function setRename(Request $request){
        $archivo = tbl_archivo::find($request->id);
        tbl_archivo::where('id',$request->id )->update(['nombre_original' => $request->name.'.'.$archivo->tipo]);
        $table = $archivo->tabla;
        $nombre = ('\App\\Models\\'.$table)::find($archivo->id_asociado);

        return response()->json([
            'respuesta' => true,
            'archivos' => tbl_archivo::where('id_asociado',$archivo->id_asociado)->where('id_cat_folder_personal', $archivo->id_cat_folder_personal)->oldest()->get(),
            'nombre' => $nombre->nombre.' '.$nombre->apellido_paterno.' '.$nombre->apellido_materno
            ], 200);
    }

    public function getArchivo($id, $car,$table){
        $nombre = ('\App\\Models\\'.$table)::find($id);
        $tbl_archivo = tbl_archivo::selectRaw('tbl_archivos.*, cat_documentos.nombre as tipo_archivo')->
        leftJoin('cat_documentos','cat_documentos.id','=','tbl_archivos.id_cat_documento')->
        where('id_asociado',$id)->where('id_cat_folder_personal', $car)->oldest()->get();

        return response()->json([
            'respuesta' => true,
            'archivos' => $tbl_archivo,
            'nombre' => $nombre->nombre. ' '.  $nombre->apellido_paterno. ' '.  $nombre->apellido_materno,
            'car' => $car
        ], 200);
    }

    public function getArchivoT($id){
        $nombre = tbl_tratamiento::find($id);

        return response()->json([
            'respuesta' => true,
            'archivos' => tbl_archivo::where('id_asociado',$id)->oldest()->get(),
            'nombre' => $nombre->nombre
        ], 200);
    }

    public function getDocumentos($path,$filename){
        $path = storage_path('app/'.$path.'/'.$filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function setTipo(Request $request){
        // dd($request->all());
        $archivo = tbl_archivo::find($request->id);
        tbl_archivo::where('id',$request->id )->update(['id_cat_documento' => $request->id_tipo]);

        $tbl_archivo = tbl_archivo::selectRaw('tbl_archivos.*, cat_documentos.nombre as tipo_archivo')->
        leftJoin('cat_documentos','cat_documentos.id','=','tbl_archivos.id_cat_documento')->
        where('id_asociado',$archivo->id_asociado)->where('id_cat_folder_personal', $archivo->id_cat_folder_personal)
        ->oldest()->get();

        return response()->json([
            'respuesta' => true,
            'archivos' => $tbl_archivo,
        ], 200);
    }
}
