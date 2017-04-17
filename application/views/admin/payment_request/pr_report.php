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
            
        </td>
    </tr>
</table>
<table border="0" style="width: 100%;" align="center">
<tr>
	<td align="center">
		<h2>PAYMENT REQUEST FORM</h2>
	</td>
</tr>
</table>
<br />

<?php
	$totalAmount = 0;
	if(isset($requisition['items']) && count($requisition['items']) > 0){	
		foreach($requisition['items'] as $item){ ?>
		<?php $grnItem = $grnItems[$item['requisition_item_id']]; ?>
		<?php
			$amount = ($grnItem['qty_accepted'] * $item['rfq_rate']);
			$totalAmount += $amount;
		?>
	<?php } ?>
<?php } ?>
        
<table border="0" style="width: 100%;">
	<tr>
    	<td style="width: 15%; border-bottom: 1px solid #000;">Payee Name </td> <td style="width: 27%; border-bottom: 1px solid #000;"><?php echo strtoupper($grn['vendor_name']); ?></td>
        <td style="width: 20%; border-bottom: 1px solid #000;">Amount in Figures </td> <td style="width: 15%; border-bottom: 1px solid #000;"><?php echo $totalAmount;?></td>
        <td style="width: 8%; border-bottom: 1px solid #000;">Date: </td> <td style="width: 15%; border-bottom: 1px solid #000;"><?php echo date('d/m/Y', strtotime($pr['pr_date'])); ?></td>
    </tr>
	<tr>
    	<td style="border-bottom: 1px solid #000;">Amount in Words: </td> <td colspan="5" style="border-bottom: 1px solid #000;"><?php echo amount_to_words($totalAmount);?></td>
    </tr>
    <tr>
    	<td style="border-bottom: 1px solid #000;">Mode of Payment: </td> <td style="border-bottom: 1px solid #000;"><?php echo $pr['payment_mode'];?></td>
        <td style="border-bottom: 1px solid #000;">Budget: </td> <td colspan="3" style="border-bottom: 1px solid #000;"><?php echo $requisition['budget_head'];?></td>
    </tr>
    <tr>
    	<td style="border-bottom: 1px solid #000;">Donor: </td> <td style="border-bottom: 1px solid #000;"><?php echo $requisition['donor_name'];?></td>
        <td style="border-bottom: 1px solid #000;">Project: </td> <td colspan="3" style="border-bottom: 1px solid #000;"><?php echo $requisition['project_name'];?></td>
    </tr>
    <tr>
    	<td style="border-bottom: 1px solid #000;">Location: </td> <td style="border-bottom: 1px solid #000;"><?php echo $requisition['location_name'];?></td>
        <td style="border-bottom: 1px solid #000;">Activity: </td> <td colspan="3" style="border-bottom: 1px solid #000;"></td>
    </tr>
	<tr>
    	<td style="border-bottom: 1px solid #000;">Purpose of Payment: </td> <td colspan="5" style="border-bottom: 1px solid #000;"><?php echo $pr['payment_purpose'];?></td>
    </tr>
	<tr>
    	<td colspan="6" style="border-bottom: 1px solid #000;">&nbsp;</td>
    </tr>
</table>
<br />
<table border="0" style="width: 90%; margin:0 auto;">
	<tr>
	  <td colspan="2" align="center"><h3>Checklists of Documents Attached</h3></td>
	</tr>
	<tr>
	  <td width="50%">&nbsp;</td>
	  <td width="50%" align="center">Y or N or N/A</td>
	</tr>
	<tr>
	  <td>Invoice</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Goods Rec'd Note / Service Completion Report</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Purchase Order / Service Order</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Quotation Analysis / Comparative Statement</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Quotation of Suppliers with RFQ</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Requisition</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Logbook</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Contract Copy</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Travel Authorization</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Note to File</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Tender Waiver</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
	<tr>
	  <td>Reference of the file in case of Tender/Quotes</td>
	  <td style="border: 1px solid #000;">&nbsp;</td>
	</tr>
</table>
<br />
<table class="table" border="0" style="width: 100%;">
    <tr>
        <td colspan="4">Note: Please write "Y" to document attached, "N" for document not attached and "N/A" for document not relevant</td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 20%;">Requested by: </td>
        <td style="width: 30%; border-bottom: 1px solid #000;">Name </td>
        <td style="width: 30%; border-bottom: 1px solid #000;">Signature </td>
        <td style="width: 20%; border-bottom: 1px solid #000;">Date </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 20%;">Verified by: </td>
        <td style="width: 30%; border-bottom: 1px solid #000;">Name </td>
        <td style="width: 30%; border-bottom: 1px solid #000;">Signature </td>
        <td style="width: 20%; border-bottom: 1px solid #000;">Date </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 20%;">Checked by: </td>
        <td style="width: 30%; border-bottom: 1px solid #000;">Name </td>
        <td style="width: 30%; border-bottom: 1px solid #000;">Signature </td>
        <td style="width: 20%; border-bottom: 1px solid #000;">Date </td>
    </tr>
    <tr>
        <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 20%;">Approved by: </td>
        <td style="width: 30%; border-bottom: 1px solid #000;">Name </td>
        <td style="width: 30%; border-bottom: 1px solid #000;">Signature </td>
        <td style="width: 20%; border-bottom: 1px solid #000;">Date </td>
    </tr>
</table>
  