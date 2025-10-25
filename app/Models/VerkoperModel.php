<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerkoperModel extends Model
{
    use HasFactory;

    // Table + key
    protected $table = 'verkopers';
    protected $primaryKey = 'id';

    // We don't use created_at / updated_at in this table
    public $timestamps = false;

    // Mass-assignable columns
    protected $fillable = [
        'Naam',
        'SpecialeStatus',   // 'GEEN' | 'PARTNER'
        'VerkooptSoort',    // 'SNEAKERS' | 'ETEN_DRINKEN' | ...
        'StandType',        // 'A' | 'AA' | 'AAplus' | null
        'Dagen',            // 'EEN' | 'TWEE' | null
        'LogoUrl',
        'IsActief',
        'Opmerking',
        'DatumAangemaakt',
        'DatumGewijzigd',
    ];

    // Helpful casts
    protected $casts = [
        'IsActief'        => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd'  => 'datetime',
    ];

    public function sp_GetAllVerkopers()
    {
        // try om code te runnen
        try 
        { 
            $result = DB::select( 'CALL sp_GetAllVerkopers()' );
            return $result;
        } catch (\Exception $e) 
        { 
            // logt foutmelding in laravel log bestand
            Log::error('CreateVerkoper failed: ' . $e->getMessage());
            
            // return een foutmelding
            return "Er ging iets fout, probeer later opnieuw"; 
        } 
    }
    
    public function sp_CreateVerkoper($naam, $specialeStatus, $verkooptSoort, $standType, $dagen, $logoUrl, $isActief, $opmerking) // <- Parameters
    {   
        // try om code te runnen
        try 
        { 
            // DB = class
            // selectOne = function binnen class DB
            // selectOne gebruiken omdat ik maar een row verwacht als resultaat
            DB::selectOne( 
                // Stored Procedure aanroepen met alle parameters
                'CALL sp_CreateVerkoper
                (
                    :Naam, 
                    :SpecialeStatus,
                    :VerkooptSoort, 
                    :StandType, 
                    :Dagen, 
                    :LogoUrl, 
                    :IsActief, 
                    :Opmerking
                )',
                [
                    // Bind parameters aan waarden
                    'Naam'           => $naam, 
                    'SpecialeStatus' => $specialeStatus, 
                    'VerkooptSoort'  => $verkooptSoort, 
                    'StandType'      => $standType, 
                    'Dagen'          => $dagen, 
                    'LogoUrl'        => $logoUrl, 
                    'IsActief'       => $isActief, 
                    'Opmerking'      => $opmerking, 
                ]
            ); 

        // als try is gefailed catch error en logt het
        } catch (\Exception $e) 
        { 
            // logt foutmelding in laravel log bestand
            Log::error('CreateVerkoper failed: ' . $e->getMessage());
            
            // return een foutmelding
            return "Er ging iets fout, probeer later opnieuw"; 
        } 
    } 
    
    public function sp_GetVerkoperByNaam($naam) 
    { 
        // try om code te runnen
        try 
        {   
            // DB = class
            // selectOne = function binnen class DB
            // selectOne gebruiken omdat ik maar een row verwacht als resultaat
            $row = DB::selectOne(
                // Stored Procedure aanroepen met parameter
                'CALL sp_GetVerkoperByNaam
                (
                    :Naam
                )', 
                [
                    // Bind parameter aan waarde
                    'Naam' => $naam
                ]
            ); 
            
            // checkt of $row identiek is aan null
            // als ze gelijk zijn krijg je TRUE wat in dit geval niet goed is wat betekend dat er een identieke naam bestaat in de DB
            // als ze niet gelijk zijn krijg je FALSE
            return $row !== null;
        // als try is gefailed catch error en logt het
        } catch (\Exception $e) 
        { 
            // logt foutmelding in laravel log bestand
            Log::error('CreateVerkoper failed: ' . $e->getMessage());

            // return een foutmelding
            return "Er ging iets fout, probeer later opnieuw"; 
        } 
    }


    //FIX
    public function sp_getVerkoperById($id)
    {
        // gebruik try om mogelijke fouten af te vangen
        try {
            // log dat de stored procedure word uitgevoerd
            Log::info('EXECUTING sp_UpdateVerkoper', ['id' => $id]);
            
            // voer stored procedute uit en zet het resultaat in $result
            $result = DB::selectOne('CALL sp_getVerkoperById(?)', [$id]);

            // controleer of $result leeg is log dat het fout is gegaan
            if (!$result) {
                Log::info('sp_UpdateVerkoper EXECUTED SUCCESFULLY  NO ID FOUND!');

            // anders log dat het goed is gegaan
            } else {
                Log::info('sp_UpdateVerkoper EXECUTED SUCCESFULLY ID FOUND', ['ID' => $result] );
            }
            
            // geef result terug
            return $result;

        // error afhandelen
        } catch (\Exception $e) {
            // logt foutmelding in laravel.log bestand
            Log::error('EXECUTION sp_getVerkoperById FAILED: ' . $e->getMessage());
            
            // return een foutmelding
            return "Er ging iets fout, probeer later opnieuw"; 
        }
    }

    public function sp_UpdateVerkoper($id, $data) // <- Parameters
    {   
        // gebruik try om mogelijke fouten af te vangen
        try { 
            // log dat de stored procedure word uitgevoerd
            Log::info('EXECUTING sp_UpdateVerkoper');
            
            // voer de stored procedure uit en zet resultaat in $result
            $result = DB::select('CALL sp_UpdateVerkoper(?, ?, ?, ?, ?, ?, ?)', [ // <- ? = placeholder. plaatsen worden genomen door waarden in array
                $id,
                $data['Naam'],
                $data['SpecialeStatus'],
                $data['VerkooptSoort'],
                $data['StandType'],
                $data['Dagen'],
                $data['LogoUrl'] ?? null // <- als LogoUrl er is dan dat ander null
            ]);

            // log dat het goed is gegaan
            Log::info('sp_UpdateVerkoper EXECUTED SUCCESFULLY');

            // geef result terug
            return $result;
        
        // error afhandelen
        } catch (\Exception $e) {
            // logt foutmelding in laravel.log bestand
            Log::error('EXECUTION sp_UpdateVerkoper FAILED: ' . $e->getMessage());
            
            // return een foutmelding
            return "Er ging iets fout, probeer later opnieuw"; 
        }
    } 

    /*
        Verwijder verkoper op id
    */
    public function sp_DeleteVerkoper($id)
    {    
        // gebruik try om mogelijke fouten af te vangen
        try {   
            // log dat de stored procedure word uitgevoerd
            Log::info('EXECUTING sp_DeleteVerkoper ON', ['id' => $id]);
            
            // voer de stored procedure uit en sla het resultaat op in $result
            $result = DB::selectOne(
                'CALL sp_DeleteVerkoper(:id)', 
                [
                    'id' => $id
                ]);
            
            // controleer of $result leeg is log dat het fout is gegaan
            if (!$result) {
                Log::info('sp_DeleteVerkoper EXECUTION FAILED ');

            // anders log dat het goed is gegaan
            } else {
                Log::info('sp_DeleteVerkoper EXECUTED SUCCESFULLY ');
            }
            
            // geef result terug
            return $result->affected ?? 0; // <- checkt hoeveel rijen zijn beinvloed ander geeft het 0 (dus niet succesvol)

        // error afhandelen
        } catch (\Exception $e) { 
            // logt foutmelding in laravel.log bestand
            Log::error('EXECUTION sp_DeleteVerkoper FAILED: ' . $e->getMessage());
            
            // return een foutmelding
            return "Er ging iets fout, probeer later opnieuw"; 
        } 
    }
}
