<table border="0" style="width: 100%;">
<tr>
	<td>
		<h4>Dear Sir,<br>
		REQUEST FOR PRICE QUOTATION</h4>
	</td>
</tr>
<tr>
	<td>We shall be glad if you could be quote your lowest selling prices(s) in respect of item(s) see out below.</td>
</tr>
</table>

<table border="1" style="width: 100%;">
	<tr>
	  <th width="10%">Sr No.</th>
	  <th width="20%">Items</th>
	  <th width="20%">Description</th>
	  <th width="15%">Unit</th>
	  <th width="10%">Estimated Quantity</th>
	  <th width="10%">Unit Rate</th>
	  <th width="15%">Total Amount</th>
	</tr>
	<tr>
		<td colspan="7"> <b><?php echo $requisition['description'];?></b> </td>
	</tr>
	<?php if(isset($requisitionItems) && count($requisitionItems) > 0){
			$count = 1;
			$unitRate = 0;
			$totalAmount = 0;
			foreach($requisitionItems as $quote){ ?>
			<tr>
				<td><?php echo $count;?></td>
				<td><?php echo $quote['item_name'];?></td>
				<td><?php echo $quote['item_desc'];?></td>
				<td><?php echo $quote['unit'];?></td>
				<td><?php echo $quote['quantity'];?></td>
				
				<?php $unitRate += $quote['unit_price'];?>
				<td><?php echo $quote['unit_price'];?></td>
				
				<?php $totalAmount += ($quote['quantity'] * $quote['unit_price']);?>
				<td><?php echo ($quote['quantity'] * $quote['unit_price']);?></td>
			</tr>
			<?php $count++; } ?>
			<tr>
				<td colspan="5" align="center">Total</td>
				<td><?php echo $unitRate;?></td>
				<td><?php echo $totalAmount;?></td>
			</tr>
		<?php } ?>
  </table>

  <table border="none" width="100%">
	<tr>
		<td align="center">
			All rates included with holding Tax.<br/>
			Delivery at RDF Field Area Khuda Abad, Dadu.
		</td>
	</tr>
	<tr>
		<td align="left">
			Please Confirm us whether or not you can Supply the quantity mentioned above and delivery schedule.
			Please also specify your mode of payment. You should reply to this request or before <?php echo date("d-M-Y", strtotime($quotation['due_date']));?>.
		</td>
	</tr>
	<tr>
		<td align="left">Yours trustly</td>
	</tr>
	<tr>
		<td align="left">
			<h4>
				for and behalf of <br/>
				Research and Development Foundation <br/>
				Procurement Section <br/>
				RDF- Head Office Hyderabad <br/>
				Contact#: 0222-102702
			</h4>
		</td>
	</tr>
	
  </table>
  
  