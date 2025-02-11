<?php

namespace App\Services;

use App\Contracts\Export;
use App\Contracts\Import;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CSV implements Import, Export {
    const CHUNK_SIZE = 4096;

    function import(string $file): bool
    {
        //Check if file exist!!!
        $handle = fopen(Storage::path($file), 'r');
        //Check if file opened!!!

        $headers = fgetcsv($handle);

        DB::beginTransaction();
        try{
            $line = 0; $batch = [];
            while (($row = fgetcsv($handle)) !== false) {
                $row = array_combine($headers, $row);
                $line++;

                if($this->isAllowedRow($row) === false){ continue; }
                $batch[] = $row;
                /**
                 *
                 */

                if ($line % self::CHUNK_SIZE === 0) {
                    DB::table('user_info')->insert($batch);
                    $batch = [];
                }
            }

            if(empty($batch) === false){
                DB::table('user_info')->insert($batch);
            }

        }catch (\Exception $e){
            DB::rollBack();
            //Log and show error, m.b. use custom exception.
//            throw new \Exception($e->getMessage());
            return false;
        }

        DB::commit();

        return true;
    }

    function background_export(string $path): bool
    {
        throw new \Exception('Not implemented');
//        Check if file exist, and return false if existed.
//        dispatch(new ExportCsvJob($path));
//        return true;
    }

    /**
     * DRY!!! Move method f. ---> trait.
     * This method doesn't need to know anything about Response!!!
     * @return StreamedResponse
     */
    function stream_export(): StreamedResponse
    {
        $stream = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'id',
                'email',
                'firstname',
                'lastname',
                'age',
                'country',
                'city',
                'date'
            ]);

            DB::table('user_info')
                ->orderBy('id')
                ->chunk(self::CHUNK_SIZE, function ($users) use ($handle) {
                    foreach ($users as $user) {
                        fputcsv($handle, [
                            $user->id,
                            $user->email,
                            $user->firstname,
                            $user->last_name,
                            $user->age,
                            $user->country,
                            $user->city,
                            $user->date,
                        ]);
                    }
                });

            fclose($handle);
        });

        return $stream;
    }

    /**
     * @param array $row
     * @return bool
     *
     * Дані повинні валідуватися при імпорті та:
     * заборонені поштові домени: mail.ru, ya.ru
     * дозвонені країни: ua, uk, us
     */
    protected function isAllowedRow(array $row) : bool
    {
        $notAllowedMailDomains = ['mail.ru', 'ya.ru']; //Hardcoded data!!!
        $allowedCountries = ['ua', 'uk', 'us']; //Hardcoded data!!!

        $email  = mb_strtolower($row['email']);
        $country = mb_strtolower($row['country']);

        foreach ($notAllowedMailDomains as $domain) {
            if(mb_strstr($email, $domain) !== false) { return  false; }
        }

        return in_array($country, $allowedCountries);
    }
}
