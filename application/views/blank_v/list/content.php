<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0"><?php echo $header; ?></h3>
    </div>
</div>

<section id="horizontal-vertical">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <?php
                        require_once APPPATH.'third_party/phpSpreadSheet/autoload.php';
                        use PhpOffice\PhpSpreadsheet\Spreadsheet;
                        use PhpOffice\PhpSpreadsheet\IOFactory;
                        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
                        use PhpOffice\PhpSpreadsheet\Writer\Csv;

                        $fileName = FCPATH.'app-assets/nanoSize.csv';

                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        $reader->setLoadAllSheets();
                        $reader->setReadDataOnly(true);

                        /* Set CSV parsing options */
                        $reader->setDelimiter(',');
                        $reader->setEnclosure('"');
                        $reader->setSheetIndex(0);

                        $spreadsheet = $reader->load($fileName);

                        $fileData = $spreadsheet->getActiveSheet()->toArray(null,false,true,true);
                        for($i=4;$i<=count($fileData);$i++){
                            if((!empty($fileData[$i]['B']) || $fileData[$i]['B']!="") && (!empty($fileData[$i]['C']) || $fileData[$i]['C']!="") && (!empty($fileData[$i]['D']) || $fileData[$i]['D']!="")){
                                echo trim($fileData[$i]['B']).'<br>';
                            }
                        }
                        ?>
                        <pre>
                            <?php
                            print_r($fileData);
                            ?>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
