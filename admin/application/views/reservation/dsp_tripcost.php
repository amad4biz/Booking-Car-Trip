<div class="row">
	<h4 class="header green" style="margin-left: 13px; margin-right: 13px;">Trip Cost</h4>
	<div class="col-xs-12">
		<div class="table-responsive">
			<table id="costtable" class="table table-striped table-bordered table-hover" id="sample-table-1"
				cost="<?php if(isset($cost['cost'])){ echo $cost['cost'];}else{ echo '0';} ?>" 
				tipamount="<?php if(isset($cost['tipAmount'])){ echo $cost['tipAmount'];}else{ echo '0';} ?>" 
				totalCost="<?php if(isset($cost['totalcost'])){ echo $cost['totalcost'];}else{ echo '0';} ?>" 
				miles="<?php echo $cost['distance'] ?>"
				discount="<?php echo $cost['discount'] ?>"
			>
				<thead>
					<tr>
						<th># of Passenger</th>
						<th>Miles</th>
						<th>Trip Cost</th>
						<th>Tip</th>
						<th>Discount</th>
						<th>Total Fare</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td id="noOfPassengerContainer"><?php echo $cost['passengers'] ?></td>
						<td><?php echo $cost['distance'] ?> miles</td>
						<td>
							$<input type="text" name="tripCostField" value="<?php if(isset($cost['cost']) && is_numeric($cost['cost'])){ echo number_format($cost['cost'], 2);}else{ echo '0';} ?>" onBlur="updateCosts();" onChange="updateCosts()" 
							<?php if(isset($_POST['priceCalculationType']) && $_POST['priceCalculationType'] == 1){ echo ' disabled="disabled" ';} ?>
						    />
							<label for="priceCalculationType"><input type="checkbox" id="priceCalculationType" name="priceCalculationType" value="1"
							<?php if(isset($_POST['priceCalculationType']) && $_POST['priceCalculationType'] == 1){ echo ' checked="checked" ';} ?> 
							/> Price auto Calculate</label> 
						</td>
						<td class="tdTipAmount">$<?php if(isset($cost['tipAmount']) && is_numeric($cost['tipAmount']) ){ echo number_format($cost['tipAmount'], 2);}else{ echo '0';} ?></td>
						<td class="tdDiscount">$<?php if(isset($cost['discount'])){ echo $cost['discount'];}else{ echo '0';} ?></td>
						<td class="tdTotalCost">$<?php if(isset($cost['totalcost']) && is_numeric($cost['totalcost']) ){ echo number_format($cost['totalcost'], 2);}else{ echo '0';} ?></td>
					</tr>							
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php exit; ?>