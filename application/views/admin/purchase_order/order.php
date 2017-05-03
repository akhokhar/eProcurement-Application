<style type="text/css">
	table {
		font-family:Arial, Helvetica, sans-serif;
	}
</style>
<table border="0" style="width: 100%;">
    <tr>
        <td style="width: 20%;">
            <img src="<?php echo $base_url . $this->config->item('logo'); ?>" alt="<?php echo $this->config->item('site_name'); ?>" />
        </td>
        <td style="width: 30%;">
            <?php echo $this->config->item('site_desc'); ?>
        </td>
        <td style="width: 25%;">
        </td>
        <td style="width: 25%; vertical-align:top;">
            <table border="0">
                <tr>
                    <td><u>Purchase Date: <?php echo date('d/m/Y', strtotime($order['po_date'])); ?></u></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table border="0" style="width: 100%;" align="center">
<tr>
	<td align="center">
		<h4>Purchase Order / Work Order</h4>
	</td>
</tr>
</table>

<table border="0" style="width: 100%;" align="center">
<tr>
	<td>Purchase Order No: </td>
	<td style="border-bottom: solid 1px;"><?php echo $order['po_num'];?></td>
	<td style="width:12%">&nbsp;</td>
	<td rowspan="2" align="left">RDF House NO. D-6, Naseem Nagar Phase III, <br> Qasimabad Hyderabad. Ph+22-2651728</td>
</tr>
<tr>
	<td>Tender Ref/Quotation NO:</td>
	<td style="border-bottom: solid 1px;"><?php echo $quotation['rfq_num'];?></td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>Date</td>
	<td style="border-bottom: solid 1px;"><?php echo date("d/m/Y", strtotime($order['po_date']));?></td>
	<td style="width:12%;">&nbsp;</td>
	<td>Delivery Date: <?php echo (!empty($order['delivery_date']) && $order['delivery_date'] != "0000-00-00")?date("d/m/Y", strtotime($order['delivery_date'])):"N/A";?></td>
</tr>
</table>

<table border="1" style="width: 100%;" align="center">
<tr>
	<td align="center">&nbsp;</td>
</tr>
<tr>
	<td align="center">&nbsp;</td>
</tr>
</table>

<table border="0" style="width: 100%;" align="center">
<tr>
	<td style="width: 30%";>Delivery Address</td>
	<td style="border-bottom: solid 1px;"><?php echo $order['delivery_address'];?></td>
	
</tr>
<tr>
	<td colspan="2" style="border-bottom: solid 1px;">&nbsp;</td>
</tr>
<tr>
	<td style="width: 30%";>Delivery Date (On or Before)</td>
	<td style="border-bottom: solid 1px;">&nbsp;</td>
	
</tr>
</table>


<table border="1" style="width: 100%;">
	<tr>
	  <th width="10%">Sr No.</th>
	  <th width="10%">Unit</th>
	  <th width="10%">Quantity</th>
	  <th width="10%">Unit Price</th>
	  <th width="45%">Description</th>
	  <th width="15%">Cost</th>
	</tr>
	
	<?php if(isset($requisition['items']) && count($requisition['items']) > 0){
			$count = 1;
			$unitRate = 0;
			$totalAmount = 0;
			foreach($requisition['items'] as $item){ ?>
			<tr>
				<td><?php echo $count;?></td>
				<td><?php echo $item['unit'];?></td>
				<td><?php echo $item['quantity'];?></td>
				<td><?php echo $item['rfq_rate'];?></td>
				<td><?php echo $item['item_desc'];?></td>
				
				<?php
					$amount = ($item['quantity'] * $item['rfq_rate']);
					$totalAmount += $amount;
				?>
				<td><?php echo $amount;?></td>
			</tr>
			<?php $count++; } ?>
			<tr>
				<td colspan="3" align="left">White: Supplier</td>
				<td colspan="2" rowspan="3">&nbsp;</td>
				<td rowspan="3"><?php echo $totalAmount;?></td>
			</tr>
			<tr border="1">
				<td colspan="3" align="left">Blue: Purchase to Accounts</td>
			</tr>
			<tr border="1">
				<td colspan="3" align="left">Yellow: Purchaser/Logistics</td>
			</tr>
		<?php } ?>
  </table>


  <table border="none" width="100%">
	<tr>
		<td colspan="2" align="left">
			Purchase Order number must appear on all pertinent documentation from supplier Concern reserves the right to cancel this order if goods are not delivers as agreed Goods furnished not in accordance with our Specification will be returned at supplier expenses.
		</td>
	</tr>
	<tr>
		<td style="width:40%"> Prepared By: Procurement Section:</td>
		<td style="border-bottom: solid 1px;">&nbsp;  </td>
	</tr>
  </table>
  
  