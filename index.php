<?php

class PriceList {

    public $file_path = __DIR__.'/D4 Price List_2017.csv';

    private function getParsedCSV()
    {
        $csvFile = file($this->file_path);
        $csvArray = array_map('str_getcsv', $csvFile);
        $data = [];
        $headers = array_shift($csvArray);

        foreach ($csvArray as $line)
        {
            $data[] = array_combine(
                $headers,
                $line
            );
        }

        return $data;
    }

    public function getAll()
    {
        return $this->toJSON($this->getParsedCSV());
    }

    public function searchByKey($key, $val)
    {
        $all_data_arr = $this->getParsedCSV();
        $filtered_data = [];

        foreach ($all_data_arr as $item)
        {
            $search_in = $item[$key];

            if (stripos($search_in, $val) !== false)
            {
                array_push($filtered_data, $item);
            }
        }

        return $this->toJSON($filtered_data);
    }

    private function toJSON($arr)
    {
        return json_encode($arr);
    }

}

$list = new PriceList();

if(isset($_GET['all']))
{
    echo $list->getAll();
    die;
}

if(isset($_GET['search']))
{
    echo $list->searchByKey("Zaneen Model #", 'D4-100');
    die;
}

die;

