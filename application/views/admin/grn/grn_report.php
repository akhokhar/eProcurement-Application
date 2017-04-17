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
                    <td><u>Date: <?php echo date('d/m/Y', strtotime($grn['grn_date'])); ?></u></td>
                </tr>
                <tr>
                    <td><u>GSRI# <?php echo $grn['grn_num']; ?></u></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table border="0" style="width: 100%;" align="center">
<tr>
	<td align="center">
		<h2>Goods / Service Receiving and Inspection Report</h2>
        <p>Supplier and Purchase Information</p>
	</td>
</tr>
</table>

<table border="1" style="width: 100%;" align="center">
	<tr style="background-color: #000;">
    	<td style="color: #FFF;">Supplier's Identity</td>
        <td style="color: #FFF;">Purchase Order No:</td>
        <td style="color: #FFF;">Delivery Challan No:</td>
    </tr>
	<tr>
    	<td><?php echo $grn['vendor_name']; ?></td>
        <td><?php echo $order['po_num']; ?></td>
        <td><?php echo $grn['delivery_challan_no']; ?></td>
    </tr>
	<tr style="background-color: #000;">
    	<td style="color: #FFF;">Invoice Reference:</td>
        <td style="color: #FFF;">Date Received:</td>
        <td style="color: #FFF;">Mode of Delivery:</td>
    </tr>
	<tr>
    	<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>

<table border="1" style="width: 100%;">
	<tr>
	  <th colspan="9" width="10%">Quantity and cost details</th>
	</tr>
	<tr>
	  <th rowspan="2" width="5%">Sr No.</th>
	  <th rowspan="2" width="10%">Inventory Code/Unit</th>
	  <th rowspan="2" width="20%">Description</th>
	  <th colspan="3" width="30%">Quantity</th>
	  <th rowspan="2" width="10%">Unit Price</th>
	  <th rowspan="2" width="10%">Total Cost</th>
	  <th rowspan="2" width="15%">Remarks</th>
	</tr>
    <tr>
	  <th width="10%">Received</th>
	  <th width="10%">Accepted</th>
	  <th width="10%">Rejected</th>
	</tr>
	
	<?php if(isset($requisition['items']) && count($requisition['items']) > 0){
		$count = 1;
		$unitRate = 0;
		$totalAmount = 0;
		foreach($requisition['items'] as $item){ ?>
        <?php $grnItem = $grnItems[$item['requisition_item_id']]; ?>
		<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo $item['unit']; ?></td>
			<td><?php echo $item['item_name']; ?></td>
			<td align="center"><?php echo $grnItem['qty_received']; ?></td>
			<td align="center"><?php echo $grnItem['qty_accepted']; ?></td>
			<td align="center"><?php echo ($grnItem['qty_received']-$grnItem['qty_accepted']); ?></td>
			<td><?php echo $item['rfq_rate']; ?></td>
			<?php
				$amount = ($grnItem['qty_accepted'] * $item['rfq_rate']);
				$totalAmount += $amount;
			?>
			<td><?php echo $amount;?></td>
			<td><?php echo $grnItem['remarks'];?></td>
			
			
		</tr>
		<?php $count++; } ?>
		<tr>
			<td colspan="7" align="left">Total: <?php echo amount_to_words($totalAmount);?></td>
			<td colspan="2"><?php echo $totalAmount;?></td>
		</tr>
</table>
		<?php } ?>
        

<table class="table" border="1" style="width: 100%;">
    <tr>
        <td colspan="3" align="center">Receipt acknowledgement and Approval</td>
    </tr>
    <tr>
        <td style="width: 40%;" align="center">Attachments:</td>
        <td style="width: 30%;" align="center">Prepared by</td>
        <td style="width: 30%;" align="center">Approved by</td>
    </tr>
    <tr>
        <td rowspan="3" align="left">
        	<table style="width: 100%;">
            	<tr>
                	<td style="width: 50px; height: 15px; border: 1px solid #000;">&nbsp;</td>
                    <td>Purchase Order</td>
                </tr>
            	<tr>
                	<td style="width: 50px; height: 15px; border: 1px solid #000;">&nbsp;</td>
                    <td>Delivery Challan</td>
                </tr>
            	<tr>
                	<td style="width: 50px; height: 15px; border: 1px solid #000;">&nbsp;</td>
                    <td>Receiving and inspection report</td>
                </tr>
            	<tr>
                	<td style="width: 50px; height: 15px; border: 1px solid #000;">&nbsp;</td>
                    <td>Expected from updated inventory record</td>
                </tr>
            </table>
        </td>
        <td style="border: 1px solid #000;">&nbsp;</td>
        <td style="border: 1px solid #000;">&nbsp;</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;" align="center">Designation</td>
        <td style="border: 1px solid #000;" align="center">Designation</td>
    </tr>
    <tr>
        <td style="border: 1px solid #000;">&nbsp;</td>
        <td style="border: 1px solid #000;">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="3" align="center" style="border: 1px solid #000;">We hereby certify that all the goods/services have been received and inspected by us and we have found all the goods are in usable condition and there are no shortage and / or damages excepted as noted below.</td>
    </tr>
    <tr>
        <td colspan="3" align="center" style="border: 1px solid #000;">Observations</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000;">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000;">&nbsp;</td>
    </tr>
    <tr>
        <td>(Authorized Signatures)</td>
        <td>(Authorized Signatures)</td>
        <td>(Authorized Signatures)</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid #000; height:50px;">&nbsp;</td>
    </tr>
    <tr>
        <td>
        Name: _________________<br />
        Date: __________________
        </td>
        <td>
        Name: _________________<br />
        Date: __________________
        </td>
        <td>
        Name: _________________<br />
        Date: __________________
        </td>
    </tr>
    <tr>
        <td colspan="3" align="center" style="border: 1px solid #000;">Distribution</td>
    </tr>
    <tr>
        <td colspan="3" align="center" style="border: 1px solid #000;">
        Original : Finance Department along with documents as checked above in attachements<br />
        Duplicate : Retained by Inventory Controller.
        </td>
    </tr>
</table>
  