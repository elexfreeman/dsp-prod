<?php

// общая рамка
$style_wrap = array (
        'borders'=>array(
            'outline' => array (
                'style'=>PHPExcel_Style_Border::BORDER_THICK //если поставить NONE рамки не будет
             ),
             
             'allborders'=>array(
                'style'=>PHPExcel_Style_Border::BORDER_THIN,
                'color'=> array(
                 'rgb'=>'696969'
                 )
             )
         )
        
);
 //заголовок   
$style_header = array (
            'font'=> array(
               'bold'=>true, 
               'name'=>'Times New Roman',
               'size'=> 20
            ),
            
            'alignment'=> array (
               'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
            ),
            'fill' => array (
               'type' => PHPExcel_STYLE_FILL::FILL_SOLID, // заливка
               'color' => array (
                 'rgb' => 'CFCFCF'
               ) 
            )
);
//подшапка        
$style_headlines = array (
            'font'=> array(
               'bold'=>true,
               'italic' =>true,
               'name'=>'Times New Roman',
               'size'=> 10
            ),
            
            'alignment'=> array (
               'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_RIGHT,
               'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
            ),
            'fill' => array (
               'type' => PHPExcel_STYLE_FILL::FILL_SOLID, // заливка
               'color' => array (
                 'rgb' => 'DFDEDE'
               ) 
            ),
            'borders' => array (
            
               'bottom' => array (
                  'style'=>PHPExcel_Style_Border::BORDER_THICK
              
              )
            )
);
//выравнивание подшапки        
$style_headlines_val = array (
            'font'=> array(
               /*'bold'=>true, */
               'italic' =>true,
               'name'=>'Times New Roman',
               'size'=> 10
            ),
            
            'alignment'=> array (
               'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
               'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
            ),
            'fill' => array (
               'type' => PHPExcel_STYLE_FILL::FILL_SOLID, // заливка
               'color' => array (
                 'rgb' => 'DFDEDE'
               ) 
            ),
            'borders' => array (
            
               'bottom' => array (
                  'style'=>PHPExcel_Style_Border::BORDER_THICK
              
              )
            )
 );
 
 //заголовки
 $style_head = array (
            'font'=> array(
               'bold'=>true, 
               //'italic' =>true,
               'name'=>'Times New Roman',
               'size'=> 10
            ),
            
            'alignment'=> array (
               'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
            ),
            'fill' => array (
               'type' => PHPExcel_STYLE_FILL::FILL_SOLID, // заливка
               'color' => array (
                 'rgb' => 'DFDEDE'
               ) 
            ),
            'borders' => array (
            
               'bottom' => array (
                   'style'=>PHPExcel_Style_Border::BORDER_THICK
              
              )
            )
 );        

$style_text = array (
          
            'alignment'=> array (
                  'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
                   'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER  
            )
);

// Забыл что делает
 $style_all = array (
          
            'font'=> array(
               'bold'=>true 
               //'italic' =>true,
              // 'name'=>'Times New Roman',
              // 'size'=> 10
            ),
            'borders' => array (
            
               'bottom' => array (
                  'style'=>PHPExcel_Style_Border::BORDER_THICK
              
               )
            )   
            
 );
