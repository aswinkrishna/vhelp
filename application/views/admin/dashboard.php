
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
       
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3">
            <a href="<?php  echo base_url() ;?>admin/user_list">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
                <?php
               $userCount              =  $this->M_admin->getCountOfUsers(1,1)  ;  
                $providerCount     = $this->M_admin->getCountOfUsers(2,1)  ; 
                $getJobRequestsCount  = $this->M_admin->getJobRequestsCount()  ; 
                 $getJobQuotationCount  = $this->M_admin->getJobQuotationCount()  ; 
                 
               
                ?>
              <h4>Users</h4>
              <p><b><?php  echo $userCount;?></b></p>
            </div>
          </div>
            </a>
        </div>
        <?php /*
        <div class="col-md-6 col-lg-3">
            <a href="<?php  echo base_url() ;?>admin/request_list">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-reply-all fa-3x"></i>
            <div class="info">
              <h4>Job requests</h4>
              <p><b><?php  echo $getJobRequestsCount;?></b></p>
            </div>
          </div>
            </a>
        </div>
        */ ?>
        <div class="col-md-6 col-lg-3">
              <a href="<?php  echo base_url() ;?>admin/provider_list">
          <div class="widget-small warning coloured-icon"><i class="icon fa  fa-users fa-3x"></i>
            <div class="info">
              <h4>Providers</h4>
              <p><b><?php  echo $providerCount;?></b></p>
            </div>
          </div>
              </a>
        </div>
        <div class="col-md-6 col-lg-3" style="display: none;">
             <a href="<?php  echo base_url() ;?>admin/quotation_list">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
            <div class="info">
              <h4>Quotations</h4>
              <p><b><?php  echo $getJobQuotationCount;?></b></p>
            </div>
          </div>
             </a>
        </div>
      </div>
      <div class="row">
        <style>
                #container::before{
                    padding: 0;
                }
                  #container2::before{
                    padding: 0;
                }
                 #container3::before{
                    padding: 0;
                }
                 #container4::before{
                    padding: 0;
                }
                  #container5::before{
                    padding: 0;
                }
                  #container6::before{
                    padding: 0;
                } 
                  #container7::before{
                    padding: 0;
                } 
                 #container8::before{
                    padding: 0;
                } 
            </style>
        <?php /*
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title" >Monthly  job request</h3>
            <div class="embed-responsive embed-responsive-16by9" id="container" >
<!--            <div id="container" style="min-width: 310px; height: auto; margin: 0 auto"></div>-->
            </div>
            
          </div>
        </div>
        */ ?>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">User type wise comparison</h3>
            <div class="embed-responsive embed-responsive-16by9" id="container2">
             
            </div>
          </div>
        </div>
        <?php /*
        <div class="col-md-6">
            <div class="tile">
            <h3 class="tile-title">Status wise comparison</h3>
            <div class="embed-responsive embed-responsive-16by9" id="container3">
             
            </div>
          </div>
        </div>
        */ ?>
      </div>
      <div class="row">
        <?php /*
        <div class="col-md-6">
           <div class="tile">
            <h3 class="tile-title">Service type wise  graph</h3>
            <div class="embed-responsive embed-responsive-16by9" id="container4">
             
            </div>
          </div>
        </div>
          <div class="col-md-6">
           <div class="tile">
            <h3 class="tile-title">Provider </h3>
            <div class="embed-responsive embed-responsive-16by9" id="container5">
             
            </div>
          </div>
        </div>
          <div class="col-md-6">
           <div class="tile">
            <h3 class="tile-title">Provider vs Job requests graph</h3>
            <div class="embed-responsive embed-responsive-16by9" id="container6">
             
            </div>
          </div>
        </div>
           <div class="col-md-6">
           <div class="tile">
            <h3 class="tile-title">Job locations</h3>
            <div class="embed-responsive embed-responsive-16by9" id="map">
             
            </div>
          </div>
        </div>
             <div class="col-md-6">
           <div class="tile">
            <h3 class="tile-title">Provider locations</h3>
            <div class="embed-responsive embed-responsive-16by9" id="map2">
             
            </div>
          </div>
        </div>
          */ ?>
        <div class="col-md-6" style="display: none;">
           <div class="tile">
            <h3 class="tile-title">Recent quotation list</h3>
            <div class="embed-responsive embed-responsive-16by9" id="container7">
             <?php
             $limit_per_page  =10;
             $start_index  =0;
             $input['job_request_type']    = 1;
             $result   =   $this->M_admin->getJobRequestsList($input,$limit_per_page, $start_index)     ;  
            if(isset($result) && count($result)>0)
                             {
                            ?>

<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                               <th>Sl no</th>
                                                                 <th>Customer name</th>   
                     <th>Service type</th>
                     <th>Service date & time</th>
                     <th>Validity date & time </th>
                   
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php 

$p=1;
 foreach($result as $rows) 
 {
     
    $profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/user_dummy.png";  
     
 if($posts['provider_id']>0)
 {
$response =     $this->M_admin->getProviderResponseStatus($rows->job_request_id,$posts['provider_id'])     ;  
 }
 else
 {
     $response  = array();
 }
//print_r($response);
$postedDate = date("Y-m-d H:i:s",strtotime($rows->job_request_id));    

  ?>
                                                        <tr>
                     <td><?php  echo $p; ?></td>
                      <?php /*<td><img src="<?php echo $profileImage;?>" class="profileIcon"> </td>*/?>
                     <td>  <?php  echo $rows->user_first_name.' '.$rows->user_last_name; ?></td>
                    <td><?php  echo $rows->service_type_name; ?></td>
                    <td><?php  echo $rows->job_date; ?> <?php echo date('h:i A', strtotime($rows->job_time)) ?></td>
                    <td><?php  echo $rows->job_validity_date; ?> <?php echo date('h:i A', strtotime($rows->job_validity_time)) ?></td>
                     
                                                         
                                                        </tr>
                                                        <?php
                                                        $p++;
                                    }
                            ?>
                                                    </tbody>
                                                </table>
                
  <?php

}
else
{


          echo  "No Results Found";

}
              ?>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Recent job request list</h3>
            <div class="embed-responsive embed-responsive-16by9" id="container8">
              <?php
             $limit_per_page  =10;
             $start_index  =0;
             $input['job_request_type']    = 2;
             $result   =   $this->M_admin->getJobRequestsList($input,$limit_per_page, $start_index)     ;  
            if(isset($result) && count($result)>0)
                             {
                            ?>

<table border="0" cellspacing="0" cellpadding="0"  id="example2" class="table table-bordered ">
                                                    <thead>
                                                        <tr>
                                                               <th>Sl no</th>
                                                                
                                                                 <th>Customer name</th>   
                     <th>Service type</th>
                     <th>Service date & time</th>
                   
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      <?php 

$p=1;
 foreach($result as $rows) 
 {
     
    $profileImage    =   $rows->user_image!=""?base_url()."uploads/user/".$rows->user_image:base_url()."images/user_dummy.png";  
     
 if($posts['provider_id']>0)
 {
$response =     $this->M_admin->getProviderResponseStatus($rows->job_request_id,$posts['provider_id'])     ;  
 }
 else
 {
     $response  = array();
 }
//print_r($response);
$postedDate = date("Y-m-d H:i:s",strtotime($rows->job_request_id));    

  ?>
                                                        <tr>
                     <td><?php  echo $p; ?></td>
                      
                     <td>  <?php  echo $rows->user_first_name.' '.$rows->user_last_name; ?></td>
                    <td><?php  echo $rows->service_type_name; ?></td>
                    <td><?php  echo $rows->job_date; ?> <?php echo date('h:i A', strtotime($rows->job_time));//get_date_in_timezone('Asia/Dubai', date('h:i A', strtotime($rows->job_time)), 'h:i A'); ?></td>
                     
                                                         
                                                        </tr>
                                                        <?php
                                                        $p++;
                                    }
                            ?>
                                                    </tbody>
                                                </table>
                
  <?php

}
else
{


          echo  "No Results Found";

}
              ?>
            </div>
          </div>
        </div>
      </div>
    </main>
  <script type="text/javascript" src="<?php  echo base_url();?>admin_assets/js/plugins/chart.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
 <script src="https://code.highcharts.com/modules/exporting.js"></script>
 <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script type="text/javascript">
     <?php
      // $getMonthWiseCount = $this->M_admin->getMonthWiseCount(1)  ; 
                 //print_r($getMonthWiseCount);
                //$monthName = date("F", strtotime($getMonthWiseCount[0]->date_trunc));
     ?>
      
/*Highcharts.chart('container', {
  chart: {
    type: 'column'
  },
  title: {
    text: ''
  },
  subtitle: {
    text: ''
  },
  xAxis: {
    categories: [
      'Jan',
      'Feb',
      'Mar',
      'Apr',
      'May',
      'Jun',
      'Jul',
      'Aug',
      'Sep',
      'Oct',
      'Nov',
      'Dec'
    ],
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Count'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.1f} Nos</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
          credits: {
      enabled: false
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: [ {
    name: 'Job requests',
    data: [<?php echo $this->M_admin->getMonthWiseCount(2,1)>0?$this->M_admin->getMonthWiseCount(2,1):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,2)>0?$this->M_admin->getMonthWiseCount(2,2):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,3)>0?$this->M_admin->getMonthWiseCount(2,3):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,4)>0?$this->M_admin->getMonthWiseCount(2,4):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,5)>0?$this->M_admin->getMonthWiseCount(2,5):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,6)>0?$this->M_admin->getMonthWiseCount(2,6):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,7)>0?$this->M_admin->getMonthWiseCount(2,7):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,8)>0?$this->M_admin->getMonthWiseCount(2,8):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,9)>0?$this->M_admin->getMonthWiseCount(2,9):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,10)>0?$this->M_admin->getMonthWiseCount(2,10):0 ?>,<?php echo $this->M_admin->getMonthWiseCount(2,11)>0?$this->M_admin->getMonthWiseCount(2,11):0 ?>, <?php echo $this->M_admin->getMonthWiseCount(2,12)>0?$this->M_admin->getMonthWiseCount(2,12):0 ?>]

  }]
});*/
Highcharts.chart('container2', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: ''
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
    credits: {
      enabled: false
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        style: {
          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
        }
      }
    }
  },
  series: [{
    name: 'Customers',
    colorByPoint: true,
    data: [{
      name: 'Customers',
      y: <?php  echo $userCount;?>,
      sliced: true,
      selected: true
    }, {
      name: 'Providers',
      y: <?php  echo $providerCount;?>
    }]
  }]
});
Highcharts.chart('container3', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: ''
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
    credits: {
      enabled: false
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
        style: {
          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
        }
      }
    }
  },
  series: [{
    name: 'Requests',
    colorByPoint: true,
    data: [
    {
      name: 'Pending',
      y: <?php  echo $this->M_admin->getStatuswiseJobCount(0) ;?>,
      sliced: true,
      selected: true
    }, {
      name: 'Approved',
      y: <?php  echo $this->M_admin->getStatuswiseJobCount(4);?>
    }, {
      name: 'Rejected',
      y: <?php  echo $this->M_admin->getStatuswiseJobCount(2);?>
    },
            {
      name: 'Price marked',
      y: <?php  echo $this->M_admin->getStatuswiseJobCount(3);?>
    }
    ]
  }]
});
<?php
 $serviceTypes = $this->M_admin->getServiceTypesForGraph()
?>

Highcharts.chart('container4', {
  chart: {
    type: 'column'
  },
  title: {
    text: ''
  },
  xAxis: {
    categories: [
     <?php  if(count($serviceTypes)>0) {
         $i=1;
         foreach($serviceTypes as $rows)
         {
         echo "'".$rows->service_type_name."'";
         ?>
            
 
    
    <?php
    if($i!=count($serviceTypes))
    {
        echo ",";
    }
    $i++;
         }
     }
    ?>
    ]
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Total count'
    },
    stackLabels: {
      enabled: true,
      style: {
        fontWeight: 'bold',
        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
      }
    }
  },
  legend: {
    align: 'right',
    x: -30,
    verticalAlign: 'top',
    y: 25,
    floating: true,
    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
    borderColor: '#CCC',
    borderWidth: 1,
    shadow: false
  },
  tooltip: {
    headerFormat: '<b>{point.x}</b><br/>',
    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
  },
   credits: {
      enabled: false
  },
  plotOptions: {
    column: {
      stacking: 'normal',
      dataLabels: {
        enabled: true,
        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
      }
    }
  },
  series: [{
    name: 'Job requests',
    data: [
        <?php  if(count($serviceTypes)>0) {
         $i=1;
         foreach($serviceTypes as $rows)
         {
         echo $this->M_admin->getServiceTypewiseCount(2,$rows->service_type_id);
         ?>
            
 
    
    <?php
    if($i!=count($serviceTypes))
    {
        echo ",";
    }
    $i++;
         }
     }
    ?>
    ]
  }, {
    name: 'Quotations',
    data: [
        
        <?php  if(count($serviceTypes)>0) {
         $i=1;
         foreach($serviceTypes as $rows)
         {
         echo $this->M_admin->getServiceTypewiseCount(1,$rows->service_type_id);
         ?>
            
 
    
    <?php
    if($i!=count($serviceTypes))
    {
        echo ",";
    }
    $i++;
         }
     }
    ?>
        
    ]
  }
  ]
});

<?php 

 $comapny  =  $this->M_admin->getDistinctProvidersList();
?>

Highcharts.chart('container5', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: ''
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    xAxis: {
        categories: [
           'Jan',
      'Feb',
      'Mar',
      'Apr',
      'May',
      'Jun',
      'Jul',
      'Aug',
      'Sep',
      'Oct',
      'Nov',
      'Dec'
        ],
        plotBands: [{ // visualize the weekend
            from: 4.5,
            to: 6.5,
            color: 'rgba(68, 170, 213, .2)'
        }]
    },
    yAxis: {
        title: {
            text: 'Quotation count'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' Nos'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    series: [
     <?php  if(count($comapny)>0) {
         $i=1;
         foreach($comapny as $rows)
         {
             ?>
                         {
                         <?php
         echo "name:'".$rows->company_name."',";
         $provider = $rows->provider_id;
         ?>
            
    data: [<?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,1)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,1):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,2)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,2):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,3)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,3):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,4)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,4):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,5)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,5):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,6)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,6):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,7)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,7):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,8)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,8):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,9)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,9):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,10)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,10):0 ?>,<?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,11)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,11):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,1,12)>0?$this->M_admin->getMonthWiseCountCompany($provider,1,12):0 ?>]
    
    
                }
                <?php
    if($i!=count($comapny))
    {
        echo ",";
    }
    
    ?>
                <?php
                $i++;
         }
     }
    ?>
    
    
    ]
});

Highcharts.chart('container6', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: ''
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
    },
    xAxis: {
        categories: [
           'Jan',
      'Feb',
      'Mar',
      'Apr',
      'May',
      'Jun',
      'Jul',
      'Aug',
      'Sep',
      'Oct',
      'Nov',
      'Dec'
        ],
        plotBands: [{ // visualize the weekend
            from: 4.5,
            to: 6.5,
            color: 'rgba(68, 170, 213, .2)'
        }]
    },
    yAxis: {
        title: {
            text: 'Quotation count'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' Nos'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    series: [
     <?php  if(count($comapny)>0) {
         $i=1;
         foreach($comapny as $rows)
         {
             ?>
                         {
                         <?php
         echo "name:'".$rows->company_name."',";
         $provider = $rows->provider_id;
         ?>
            
    data: [<?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,1)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,1):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,2)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,2):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,3)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,3):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,4)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,4):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,5)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,5):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,6)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,6):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,7)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,7):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,8)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,8):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,9)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,9):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,10)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,10):0 ?>,<?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,11)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,11):0 ?>, <?php echo $this->M_admin->getMonthWiseCountCompany($provider,2,12)>0?$this->M_admin->getMonthWiseCountCompany($provider,2,12):0 ?>]
    
    
                }
                <?php
    if($i!=count($comapny))
    {
        echo ",";
    }
    
    ?>
                <?php
                $i++;
         }
     }
    ?>
    
    
    ]
});
    </script>
    	<script type="text/javascript" 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjz3f3QlirfEUFl1unnRdGVDyEwk-912g&sensor=false&libraries=places"></script>	
	<script type="text/javascript">
  
    
</script>	
    <script type="text/javascript">


var locations = [
				<?php

$GetAlldata=$this->M_admin->getJobsLocations();	
//print_r($GetAlldata);


 foreach($GetAlldata as $preData){


$usrcategory=$preData['style'];
if($preData['lattitude']!="" && $preData['lattitude']!=NULL)
{

echo '["'.$preData['first_name'].'",'.$preData['lattitude'].','.$preData['longitude'].',"'.$usrcategory.'"

,'.$preData['id'].',"'.$preData['image'].'"
						],';
} }?>
    ];



    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 1,
      center: new google.maps.LatLng(25.204849,55.270782),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();
    

    var marker, i;
    var markers = new Array();

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
      //  icon: 'images/marker.png',
        map: map
      });

      markers.push(marker);


      google.maps.event.addListener(marker, 'click', (function(marker, i) {

if(locations[i][5]!=""){

var imggg="<?php  echo base_url(); ?>uploads/user/"+locations[i][5]; 
}
else{

var imggg="<?php  echo base_url(); ?>images/user_dummy.png";
}
var content = "<div style = 'min-width:50px;min-height:50px; padding:0 20px;display:inline-block;'><div class='mapImage'><a href='javascript:void(0);' for='about-trainer.php?tI=" + locations[i][4] + "' class='ballonClick'><img src='" + imggg+ "'/ style='height:39px;width:39px'> </a></div><div class='mapTextName'><div class='mapTitle'><a for='about-trainer.php?tI=" + locations[i][4]+ "' href='javascript:void(0);' class='ballonClick'>" + locations[i][0] + "</a></div><div class='mapCategory'>" +locations[i][3] + " Customer</div></div></div>" 
        return function() {
          infowindow.setContent(content);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

    

  </script>
  <script type="text/javascript">


var locations = [
				<?php

$GetAlldata=$this->M_admin->getProvidersLocations();	
//print_r($GetAlldata);


 foreach($GetAlldata as $preData){


$usrcategory=$preData['style'];
if($preData['lattitude']!="" && $preData['lattitude']!=NULL)
{

echo '["'.$preData['first_name'].'",'.$preData['lattitude'].','.$preData['longitude'].',"'.$usrcategory.'"

,'.$preData['id'].',"'.$preData['image'].'"
						],';
} }?>
    ];



    var map = new google.maps.Map(document.getElementById('map2'), {
      zoom: 1,
      center: new google.maps.LatLng(25.204849,55.270782),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();
    

    var marker, i;
    var markers = new Array();

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
      //  icon: 'images/marker.png',
        map: map
      });

      markers.push(marker);


      google.maps.event.addListener(marker, 'click', (function(marker, i) {

if(locations[i][5]!=""){

var imggg="<?php  echo base_url(); ?>uploads/user/"+locations[i][5]; 
}
else{

var imggg="<?php  echo base_url(); ?>images/user_dummy.png";
}
var content = "<div style = 'min-width:50px;min-height:50px; padding:0 20px;display:inline-block;'><div class='mapImage'><a href='javascript:void(0);' for='about-trainer.php?tI=" + locations[i][4] + "' class='ballonClick'><img src='" + imggg+ "'/ style='height:39px;width:39px'> </a></div><div class='mapTextName'><div class='mapTitle'><a for='about-trainer.php?tI=" + locations[i][4]+ "' href='javascript:void(0);' class='ballonClick'>" + locations[i][0] + "</a></div><div class='mapCategory'>" +locations[i][3] + " Provider</div></div></div>" 
        return function() {
          infowindow.setContent(content);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

    

  </script>