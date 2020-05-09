<?php

$full_assembly_string = 'Microsoft.Office.Interop.Excel, Version=14.0.0.0, Culture=neutral, PublicKeyToken=71e9bce111e9429c';
$full_class_name = 'Microsoft.Office.Interop.Excel.ApplicationClass';

$e = new DOTNET($full_assembly_string, $full_class_name);
$wb = $e->workbooks->add();
$Precios = $wb->Worksheets(1);
$Precios->Name = 'Precios';
$Venta = $wb->Worksheets(2);
$Venta->Name = 'Venta';
$Tons = $wb->Worksheets(3);
$Tons->Name = 'Tons';

$Meses = Array('2014-01', '2014-02', '2014-03', '2014-04', '2014-05', '2014-06', '2014-07', '2014-08', '2014-09', '2014-10', '2014-11', '2014-12');
foreach ($Meses as $Numero => $Mes) {
   $Precios->Range("A" . ($Numero+1))->Value = $Mes;
}

$wb->SaveAs('c:\temp\Meta.2014.05.xlsx');
$wb->Close();

?>