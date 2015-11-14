			<br></br>
			<?php 
	        	$attributes = array('class' => 'selectVehicle', 'name' => 'selectVehicle', 'id' => 'selectVehicle');
	        	echo form_open('quickquote/quoteDetail', $attributes);
	        	echo form_hidden($getQuote);
                $chainflag=0;
                function asDollars($value,$vehicletype,&$chainflag) {     
                    if((strpos($_POST['pickUp_city'],'Arrowhead') !== false||strpos($_POST['pickUp_city'],'Big Bear') !== false||strpos($_POST['pickUp_city'],'Crestline') !== false) && $_POST['pickUp_state']=="CA")
                    {
                        if($_POST['trip']=="1") $value += 50;
                            else if($_POST['trip']=="2") $value += 100;
                    } else if((strpos($_POST['pickUp_city2'],'Arrowhead') !== false||strpos($_POST['pickUp_city2'],'Big Bear') !== false||strpos($_POST['pickUp_city2'],'Crestline') !== false) && $_POST['pickUp_state2']=="CA")
                    {
                        if($_POST['trip']=="1") $value += 50;
                            else if($_POST['trip']=="2") $value += 100;
                    } else if((strpos($_POST['dropOff_city'],'Arrowhead') !== false||strpos($_POST['dropOff_city'],'Big Bear') !== false||strpos($_POST['dropOff_city'],'Crestline') !== false) && $_POST['dropOff_state']=="CA")
                    {
                        if($_POST['trip']=="1") $value += 50;
                            else if($_POST['trip']=="2") $value += 100;
                    } else if((strpos($_POST['dropOff_city2'],'Arrowhead') !== false||strpos($_POST['dropOff_city2'],'Big Bear') !== false||strpos($_POST['dropOff_city2'],'Crestline') !== false) && $_POST['dropOff_state2']=="CA")
                    {
                        if($_POST['trip']=="1") $value += 50;
                            else if($_POST['trip']=="2") $value += 100;
                    } else if ($_POST['pickUp_zip']==92407||$_POST['pickUp_zip']==92314||$_POST['pickUp_zip']==91761||$_POST['pickUp_zip']==92333||$_POST['pickUp_zip2']==92407||$_POST['pickUp_zip2']==92314||$_POST['pickUp_zip2']==91761||$_POST['pickUp_zip2']==92333) {
                        if($_POST['trip']=="1") $value += 50;
                            else if($_POST['trip']=="2") $value += 100;
                    } else if ($_POST['dropOff_zip']==92407||$_POST['dropOff_zip']==92314||$_POST['dropOff_zip']==91761||$_POST['dropOff_zip']==92333||$_POST['dropOff_zip2']==92407||$_POST['dropOff_zip2']==92314||$_POST['dropOff_zip2']==91761||$_POST['dropOff_zip2']==92333) {
                        if($_POST['trip']=="1") $value += 50;
                            else if($_POST['trip']=="2") $value += 100;
                    }
		      if ($_POST['pickUp_zip']==92407||$_POST['pickUp_zip']==92314||$_POST['pickUp_zip']==91761||$_POST['pickUp_zip']==92333||$_POST['pickUp_zip2']==92407||$_POST['pickUp_zip2']==92314||$_POST['pickUp_zip2']==91761||$_POST['pickUp_zip2']==92333) {
                        $chainflag=1;
                    } else if ($_POST['dropOff_zip']==92407||$_POST['dropOff_zip']==92314||$_POST['dropOff_zip']==91761||$_POST['dropOff_zip']==92333||$_POST['dropOff_zip2']==92407||$_POST['dropOff_zip2']==92314||$_POST['dropOff_zip2']==91761||$_POST['dropOff_zip2']==92333) {
                        $chainflag=1;
                    }                 
                
                    if ($vehicletype==2) $value+=10;
                    if ($vehicletype==3) $value+=20;
                    return '$'. number_format($value);
                }
	        ?>
	        	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
	        	<script>
	        	jQuery(document).ready(function($) {
	        		passenger = <?php if(isset($_POST['passengers'])){echo $passengers;}?>;
        			if (passenger >= 4){
        				$("input.luxury-sedan, input.economy").attr('disabled', true);
        				$("input.luxury-sedan, input.economy").closest('label').find('img').css("opacity","0.5");
        				$('h3.luxury-sedan, h3.economy').text('N/A');
        			}else if(passenger == 3){
        				$("input.luxury-sedan, input.economy").removeAttr('disabled');
        				$("input.luxury-sedan, input.economy").closest('label').find('img').css("opacity","1");
        				$("input.economy").attr('disabled', true);
        				$("input.economy").closest('label').find('img').css("opacity","0.5");
        				$('h3.economy').text('N/A');
        			}else if(passenger <= 3){
        				$("input.luxury-sedan, input.economy").removeAttr('disabled');
        				$("input.luxury-sedan, input.economy").closest('label').find('img').css("opacity","1");
        			}
	        	});
	        	</script>
	        	<div class="col-sm-12 marginTop20 padding-left padding-right">
            		<div class="box vehicleDetail">
	            		<div class="boxTitle"><?php if (count($tripcost) == 0){echo 'Personal Quote';}else{echo 'Select A Vehicle';}?></div>
						<div class="boxBody imgRadio control-group">
							<?php
							 if (count($tripcost) == 0) {
							 	echo '<h3>Palm Springs region requires special pricing, please call <span style="color:blue;font-weight:bold;">866-805-4234</span> for your specific quote.</h3>';
							 } else {
								foreach ($vehicles as $vehicles_item) {
									echo '<div class="col-sm-4 text-center marginTop20">';
										echo '<input id="cost'.$vehicles_item["vehicleTypeID"].'" type="hidden" name="cost_'.$vehicles_item["vehicleTypeID"].'" value="'. asDollars($tripcost[0][str_replace('-','_',$vehicles_item["vehicleTypeCode"])], $vehicles_item["vehicleTypeID"], $chainflag).'">';
										echo '<label class="controls pricingWraper">';
										 echo '<h3 id="price'.$vehicles_item["vehicleTypeID"].'" class="pricing ' . $vehicles_item["vehicleTypeCode"] . '">' . asDollars($tripcost[0][str_replace('-','_',$vehicles_item["vehicleTypeCode"])], $vehicles_item["vehicleTypeID"], $chainflag). '</h3>';
										
										  echo '<input type="radio" class="vehicle ' . $vehicles_item["vehicleTypeCode"] . '" required="true" vehicle_name="' . $vehicles_item["vehicleType"] . '" name="vehicleType" value="' . $vehicles_item["vehicleTypeID"] . '"/>';
										  echo '<img class="img-responsive" src="../../images/' . $vehicles_item["picture"] . '">';                                                 
										echo '</label>';
									echo '</div>';
								}
							}
							 if (count($tripcost) > 0) {
							?>
							<div class="row controls">
								<div class="col-sm-12 padding-left padding-right">
									<div class="col-sm-12 boxTitle checkbox" style="margin:10px 0;" id="selectedVehicle">Vehicle Selected: <span style="color:#ffd200;">None</span>
                                        <?php if($chainflag==1){ ?>                                           
                                            <label id="chain">
                                            	<B>$100 additional If chains are required</B>
                                            </label>                                             
                                        <?php } ?>
                                    </div>
                                </div>
							</div>
							
						</div>
						<div class="clearfix"></div>
					</div>
            	</div>
            </div>
            <?php } else { ?>
            	</div>
						<div class="clearfix"></div>
					</div>
            	</div>
            </div>
			<?php } ?>
<?php 
	$footerJs = <<<EOD
		<script>
			jQuery(document).ready(function($) {
				$('.vehicle').on('click', function(){
					selectedVehicle = $(this).attr('vehicle_name');
					$('#selectedVehicle').html('Vehicle Selected: <span style="color:#ffd200;">'+ selectedVehicle+'</span>');
				});
                $('#chain').on('click', function(event){
                    event.preventDefault();
                    if(document.getElementById('chaincheck').checked==false){  
                        if(document.getElementById('price1').innerHTML!="N/A") 
                        {             
                            var price = document.getElementById('price1').innerHTML.substr(1);
                            value=parseInt(price)+100;
                            document.getElementById('price1').innerHTML="$"+value;
                            document.getElementById('cost1').value=document.getElementById('price1').innerHTML;                            
                        }
                        if(document.getElementById('price2').innerHTML!="N/A") 
                        {             
                            var price = document.getElementById('price2').innerHTML.substr(1);
                            value=parseInt(price)+100;
                            document.getElementById('price2').innerHTML="$"+value; 
                            document.getElementById('cost2').value=document.getElementById('price2').innerHTML;                            
                        }
                        if(document.getElementById('price3').innerHTML!="N/A") 
                        {             
                            var price = document.getElementById('price3').innerHTML.substr(1);
                            value=parseInt(price)+100;
                            document.getElementById('price3').innerHTML="$"+value;     
                            document.getElementById('cost3').value=document.getElementById('price3').innerHTML;                        
                        }
                        document.getElementById('chaincheck').checked=true;
                    }else{
                        if(document.getElementById('price1').innerHTML!="N/A") 
                        {             
                            var price = document.getElementById('price1').innerHTML.substr(1);
                            value=parseInt(price)-100;
                            document.getElementById('price1').innerHTML="$"+value;          
                            document.getElementById('cost1').value=document.getElementById('price1').innerHTML;                   
                        }
                        if(document.getElementById('price2').innerHTML!="N/A") 
                        {             
                            var price = document.getElementById('price2').innerHTML.substr(1);
                            value=parseInt(price)-100;
                            document.getElementById('price2').innerHTML="$"+value;   
                            document.getElementById('cost2').value=document.getElementById('price2').innerHTML;                         
                        }
                        if(document.getElementById('price3').innerHTML!="N/A") 
                        {             
                            var price = document.getElementById('price3').innerHTML.substr(1);
                            value=parseInt(price)-100;
                            document.getElementById('price3').innerHTML="$"+value; 
                            document.getElementById('cost3').value=document.getElementById('price3').innerHTML;                           
                        }
                        document.getElementById('chaincheck').checked=false;
                    }   
                    
                });    
			});
			$('#selectVehicle input[type=radio]').click(function() {
			    $("#selectVehicle").submit();
			});
		</script>
EOD;
	$footerJs = Array("type"=>"inline", "script"=>$footerJs);
	add_header_footer_cssJS('footer_js', $footerJs);
?>