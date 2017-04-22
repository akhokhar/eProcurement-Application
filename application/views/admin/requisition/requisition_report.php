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
                    <td>Date: <u><?php echo date('d/m/Y', strtotime($requisition['date_req'])); ?></u></td>
                </tr>
				<tr>
                    <td>Category <u><?php echo $requisition['category']; ?></u></td>
                </tr>
                <tr>
                    <td>Refs# <u><?php echo $requisition['requisition_num']; ?></u></td>
                </tr>
                <tr>
                    <td>Donor: <u><?php echo $requisition['donor_name']; ?></u></td>
                </tr>
                <tr>
                    <td>Project	: <u><?php echo $requisition['project_name']; ?></u></td>
                </tr>
                <tr>
                    <td>Location: <u><?php echo $requisition['location_name']; ?></u></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table border="0" style="width: 100%; text-align: center;">
<tr>
	<td>
		<h2>Purchase Requisition</h2>
	</td>
</tr>
<tr>
	<td>The following items are required at the earliest not later than <strong><u><?php echo date('d/m/Y', strtotime($requisition['date_req_until'])); ?></u></strong></td>
</tr>
<tr>
	<td style="padding: 10px 0;"><u><strong>Title: </strong><?php echo $requisition['description'];?></u></td>
</tr>
</table>

<table style="width: 100%; border: 1px solid #000;">
	<tr>
	  <th style="width: 5%; border: 1px solid #000;">Sr No.</th>
	  <th style="width: 20%; border: 1px solid #000;">Items</th>
	  <th style="width: 20%; border: 1px solid #000;">Description</th>
	  <th style="width: 10%; border: 1px solid #000;">Cost Center</th>
	  <th style="width: 10%; border: 1px solid #000;">Unit</th>
	  <th style="width: 10%; border: 1px solid #000;">Quantity</th>
	  <th style="width: 10%; border: 1px solid #000;">Estimated Unit Value Rs</th>
	  <th style="width: 15%; border: 1px solid #000;">Total Estimated Unit Value Rs</th>
	</tr>
	<?php if(isset($requisition['items']) && count($requisition['items']) > 0){
		$count = 1;
		$unitRate = 0;
		$totalAmount = 0;
		foreach($requisition['items'] as $item){ ?>
		<tr>
			<td style="border: 1px solid #000; text-align:center;"><?php echo $count;?></td>
			<td style="border: 1px solid #000;"><?php echo $item['item_name'];?></td>
			<td style="border: 1px solid #000;"><?php echo $item['item_desc'];?></td>
			<td style="border: 1px solid #000;"><?php echo $item['cost_center'];?></td>
            <td style="border: 1px solid #000;"><?php echo $item['unit'];?></td>
            <td style="border: 1px solid #000;"><?php echo $item['quantity'];?></td>
            
            <?php $unitRate += $item['unit_price'];?>
            <td style="border: 1px solid #000;"><?php echo $item['unit_price'];?></td>
            
            <?php $totalAmount += ($item['quantity'] * $item['unit_price']);?>
            <td style="border: 1px solid #000;"><?php echo ($item['quantity'] * $item['unit_price']);?></td>
		</tr>
        <?php $count++; ?>
        <?php } ?>
		<tr>
			<td style="border: 1px solid #000;" colspan="2" align="center"><strong>Amount in words:</strong></td>
            <td style="border: 1px solid #000;" colspan="4"><?php echo amount_to_words($totalAmount);?></td>
            <td style="border: 1px solid #000;"><?php echo $unitRate;?></td>
            <td style="border: 1px solid #000;"><?php echo $totalAmount;?></td>
		</tr>
	<?php } ?>
  </table>

  <table border="none" style="width: 100%; margin-top: 50px;">
	<tr>
		<td style="width: 22%; padding-right: 2%;">____________________</td>
        <td style="width: 23%; padding-right: 2%;">_______________________</td>
        <td style="width: 23%; padding-right: 2%;">____________________</td>
        <td style="width: 23%;">_______________________</td>
    </tr>
    <tr>
        <td style="padding-right: 10px; font-size: 12px;"><strong>Requested Signature</strong></td>
        <td style="padding-right: 10px; font-size: 12px;"><strong>Recommended Signature</strong></td>
        <td style="padding-right: 10px; font-size: 12px;"><strong>Verified by Signature</strong></td>
        <td style="padding-right: 10px; font-size: 12px;"><strong>Authorized by Signature</strong></td>
    </tr>
    <tr>
        <td style="padding-right: 10px; font-size: 13px;">Name: _________________<?php echo ""; ?></td>
        <td style="padding-right: 10px; font-size: 13px;">Name: _________________<?php echo ""; ?></td>
        <td style="padding-right: 10px; font-size: 13px;">Name: _________________<?php echo ""; ?></td>
        <td style="padding-right: 10px; font-size: 13px;">Name: _________________<?php echo ""; ?></td>
    </tr>
    <tr>
		<td style="padding-right: 10px; font-size: 13px;">Date: __________________</td>
		<td style="padding-right: 10px; font-size: 13px;">Date: __________________</td>
		<td style="padding-right: 10px; font-size: 13px;">Date: __________________</td>
		<td style="padding-right: 10px; font-size: 13px;">Date: __________________</td>
    </tr>
	
  </table>
  
  