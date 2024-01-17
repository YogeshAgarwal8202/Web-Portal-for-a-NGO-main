<?php
namespace PHPReportMaker12\sss;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start();

// Autoload
include_once "rautoload.php";
?>
<?php

// Create page object
if (!isset($donation_user_wise_rpt))
	$donation_user_wise_rpt = new donation_user_wise_rpt();
if (isset($Page))
	$OldPage = $Page;
$Page = &$donation_user_wise_rpt;

// Run the page
$Page->run();

// Setup login status
SetClientVar("login", LoginStatus());
if (!$DashboardReport)
	WriteHeader(FALSE);

// Global Page Rendering event (in rusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php if (!$DashboardReport) { ?>
<?php include_once "rheader.php" ?>
<?php } ?>
<?php if ($Page->Export == "" || $Page->Export == "print") { ?>
<script>
currentPageID = ew.PAGE_ID = "rpt"; // Page ID
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<script>

// Form object
var fdonation_user_wiserpt = currentForm = new ew.Form("fdonation_user_wiserpt");

// Validate method
fdonation_user_wiserpt.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj), elm;

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fdonation_user_wiserpt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}
<?php if (CLIENT_VALIDATE) { ?>
fdonation_user_wiserpt.validateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fdonation_user_wiserpt.validateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
fdonation_user_wiserpt.lists["x_user_name"] = <?php echo $donation_user_wise_rpt->user_name->Lookup->toClientList() ?>;
fdonation_user_wiserpt.autoSuggests["x_user_name"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
</script>
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<a id="top"></a>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
<!-- Content Container -->
<div id="ew-container" class="container-fluid ew-container">
<?php } ?>
<?php if (ReportParam("showfilter") === TRUE) { ?>
<?php $Page->showFilterList(TRUE) ?>
<?php } ?>
<div class="btn-toolbar ew-toolbar">
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->render("body");
	$Page->SearchOptions->render("body");
	$Page->FilterOptions->render("body");
	$Page->GenerateOptions->render("body");
}
?>
</div>
<?php $Page->showPageHeader(); ?>
<?php $Page->showMessage(); ?>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
<div class="row">
<?php } ?>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
<!-- Center Container - Report -->
<div id="ew-center" class="<?php echo $donation_user_wise_rpt->CenterContentClass ?>">
<?php } ?>
<!-- Summary Report begins -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="report_summary">
<?php } ?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<!-- Search form (begin) -->
<?php

	// Render search row
	$Page->resetAttributes();
	$Page->RowType = ROWTYPE_SEARCH;
	$Page->renderRow();
?>
<form name="fdonation_user_wiserpt" id="fdonation_user_wiserpt" class="form-inline ew-form ew-ext-filter-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($Page->Filter <> "") ? " show" : " show"; ?>
<div id="fdonation_user_wiserpt-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ew-row d-sm-flex">
<div id="c_user_name" class="ew-cell form-group">
	<label for="x_user_name" class="ew-search-caption ew-label"><?php echo $Page->user_name->caption() ?></label>
	<span class="ew-search-operator"><?php echo $ReportLanguage->phrase("="); ?><input type="hidden" name="z_user_name" id="z_user_name" value="="></span>
	<span class="control-group ew-search-field">
<?php
$wrkonchange = trim(" " . @$Page->user_name->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$Page->user_name->EditAttrs["onchange"] = "";
?>
<span id="as_x_user_name" class="text-nowrap" style="z-index: 8980">
	<input type="text" class="form-control" name="sv_x_user_name" id="sv_x_user_name" value="<?php echo RemoveHtml($Page->user_name->AdvancedSearch->SearchValue) ?>" size="30" maxlength="60" placeholder="<?php echo HtmlEncode($Page->user_name->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($Page->user_name->getPlaceHolder()) ?>"<?php echo $Page->user_name->editAttributes() ?>>
</span>
<input type="hidden" data-table="donation_user_wise" data-field="x_user_name" data-value-separator="<?php echo $Page->user_name->displayValueSeparatorAttribute() ?>" name="x_user_name" id="x_user_name" value="<?php echo HtmlEncode($Page->user_name->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<script>
fdonation_user_wiserpt.createAutoSuggest({"id":"x_user_name","forceSelect":false});
</script>
</span>
</div>
</div>
<div class="ew-row d-sm-flex">
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><?php echo $ReportLanguage->phrase("Search") ?></button>
<button type="reset" name="btn-reset" id="btn-reset" class="btn hide"><?php echo $ReportLanguage->phrase("Reset") ?></button>
</div>
</div>
</form>
<script>
fdonation_user_wiserpt.filterList = <?php echo $Page->getFilterList() ?>;
</script>
<!-- Search form (end) -->
<?php } ?>
<?php if ($Page->ShowCurrentFilter) { ?>
<?php $Page->showFilterList() ?>
<?php } ?>
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGroup = $Page->TotalGroups;
} else {
	$Page->StopGroup = $Page->StartGroup + $Page->DisplayGroups - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGroup) > intval($Page->TotalGroups))
	$Page->StopGroup = $Page->TotalGroups;
$Page->RecordCount = 0;
$Page->RecordIndex = 0;

// Get first row
if ($Page->TotalGroups > 0) {
	$Page->loadRowValues(TRUE);
	$Page->GroupCount = 1;
}
$Page->GroupIndexes = InitArray(2, -1);
$Page->GroupIndexes[0] = -1;
$Page->GroupIndexes[1] = $Page->StopGroup - $Page->StartGroup + 1;
while ($Page->Recordset && !$Page->Recordset->EOF && $Page->GroupCount <= $Page->DisplayGroups || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ew-grid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="card ew-card ew-grid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="gmp_donation_user_wise" class="<?php if (IsResponsiveLayout()) { echo "table-responsive "; } ?>ew-grid-middle-panel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ew-table-header">
<?php if ($Page->donation_id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="donation_id"><div class="donation_user_wise_donation_id"><span class="ew-table-header-caption"><?php echo $Page->donation_id->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="donation_id">
<?php if ($Page->sortUrl($Page->donation_id) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_donation_id">
			<span class="ew-table-header-caption"><?php echo $Page->donation_id->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_donation_id" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->donation_id) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->donation_id->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->donation_id->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->donation_id->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_name->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_name"><div class="donation_user_wise_user_name"><span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_name">
<?php if ($Page->sortUrl($Page->user_name) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_user_name">
			<span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_user_name" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_name) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_name->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_name->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->donation_amount->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="donation_amount"><div class="donation_user_wise_donation_amount"><span class="ew-table-header-caption"><?php echo $Page->donation_amount->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="donation_amount">
<?php if ($Page->sortUrl($Page->donation_amount) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_donation_amount">
			<span class="ew-table-header-caption"><?php echo $Page->donation_amount->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_donation_amount" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->donation_amount) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->donation_amount->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->donation_amount->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->donation_amount->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->donation_method->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="donation_method"><div class="donation_user_wise_donation_method"><span class="ew-table-header-caption"><?php echo $Page->donation_method->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="donation_method">
<?php if ($Page->sortUrl($Page->donation_method) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_donation_method">
			<span class="ew-table-header-caption"><?php echo $Page->donation_method->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_donation_method" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->donation_method) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->donation_method->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->donation_method->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->donation_method->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->donation_date->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="donation_date"><div class="donation_user_wise_donation_date"><span class="ew-table-header-caption"><?php echo $Page->donation_date->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="donation_date">
<?php if ($Page->sortUrl($Page->donation_date) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_donation_date">
			<span class="ew-table-header-caption"><?php echo $Page->donation_date->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_donation_date" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->donation_date) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->donation_date->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->donation_date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->donation_date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->donation_time->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="donation_time"><div class="donation_user_wise_donation_time"><span class="ew-table-header-caption"><?php echo $Page->donation_time->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="donation_time">
<?php if ($Page->sortUrl($Page->donation_time) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_donation_time">
			<span class="ew-table-header-caption"><?php echo $Page->donation_time->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_donation_time" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->donation_time) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->donation_time->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->donation_time->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->donation_time->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->donation_status->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="donation_status"><div class="donation_user_wise_donation_status"><span class="ew-table-header-caption"><?php echo $Page->donation_status->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="donation_status">
<?php if ($Page->sortUrl($Page->donation_status) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_donation_status">
			<span class="ew-table-header-caption"><?php echo $Page->donation_status->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_donation_status" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->donation_status) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->donation_status->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->donation_status->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->donation_status->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_gender->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_gender"><div class="donation_user_wise_user_gender"><span class="ew-table-header-caption"><?php echo $Page->user_gender->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_gender">
<?php if ($Page->sortUrl($Page->user_gender) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_user_gender">
			<span class="ew-table-header-caption"><?php echo $Page->user_gender->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_user_gender" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_gender) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_gender->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_gender->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_gender->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_mobile->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_mobile"><div class="donation_user_wise_user_mobile"><span class="ew-table-header-caption"><?php echo $Page->user_mobile->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_mobile">
<?php if ($Page->sortUrl($Page->user_mobile) == "") { ?>
		<div class="ew-table-header-btn donation_user_wise_user_mobile">
			<span class="ew-table-header-caption"><?php echo $Page->user_mobile->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer donation_user_wise_user_mobile" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_mobile) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_mobile->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_mobile->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_mobile->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGroups == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecordCount++;
	$Page->RecordIndex++;
?>
<?php

		// Render detail row
		$Page->resetAttributes();
		$Page->RowType = ROWTYPE_DETAIL;
		$Page->renderRow();
?>
	<tr<?php echo $Page->rowAttributes(); ?>>
<?php if ($Page->donation_id->Visible) { ?>
		<td data-field="donation_id"<?php echo $Page->donation_id->cellAttributes() ?>>
<span<?php echo $Page->donation_id->viewAttributes() ?>><?php echo $Page->donation_id->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_name->Visible) { ?>
		<td data-field="user_name"<?php echo $Page->user_name->cellAttributes() ?>>
<span<?php echo $Page->user_name->viewAttributes() ?>><?php echo $Page->user_name->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->donation_amount->Visible) { ?>
		<td data-field="donation_amount"<?php echo $Page->donation_amount->cellAttributes() ?>>
<span<?php echo $Page->donation_amount->viewAttributes() ?>><?php echo $Page->donation_amount->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->donation_method->Visible) { ?>
		<td data-field="donation_method"<?php echo $Page->donation_method->cellAttributes() ?>>
<span<?php echo $Page->donation_method->viewAttributes() ?>><?php echo $Page->donation_method->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->donation_date->Visible) { ?>
		<td data-field="donation_date"<?php echo $Page->donation_date->cellAttributes() ?>>
<span<?php echo $Page->donation_date->viewAttributes() ?>><?php echo $Page->donation_date->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->donation_time->Visible) { ?>
		<td data-field="donation_time"<?php echo $Page->donation_time->cellAttributes() ?>>
<span<?php echo $Page->donation_time->viewAttributes() ?>><?php echo $Page->donation_time->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->donation_status->Visible) { ?>
		<td data-field="donation_status"<?php echo $Page->donation_status->cellAttributes() ?>>
<span<?php echo $Page->donation_status->viewAttributes() ?>><?php echo $Page->donation_status->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_gender->Visible) { ?>
		<td data-field="user_gender"<?php echo $Page->user_gender->cellAttributes() ?>>
<span<?php echo $Page->user_gender->viewAttributes() ?>><?php echo $Page->user_gender->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_mobile->Visible) { ?>
		<td data-field="user_mobile"<?php echo $Page->user_mobile->cellAttributes() ?>>
<span<?php echo $Page->user_mobile->viewAttributes() ?>><?php echo $Page->user_mobile->getViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->accumulateSummary();

		// Get next record
		$Page->loadRowValues();
	$Page->GroupCount++;
} // End while
?>
<?php if ($Page->TotalGroups > 0) { ?>
</tbody>
<tfoot>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<?php if ($Page->Export <> "pdf") { ?>
<?php if ($Page->Export == "word" || $Page->Export == "excel") { ?>
<div class="ew-grid"<?php echo $Page->ReportTableStyle ?>>
<?php } else { ?>
<div class="card ew-card ew-grid"<?php echo $Page->ReportTableStyle ?>>
<?php } ?>
<?php } ?>
<!-- Report grid (begin) -->
<?php if ($Page->Export <> "pdf") { ?>
<div id="gmp_donation_user_wise" class="<?php if (IsResponsiveLayout()) { echo "table-responsive "; } ?>ew-grid-middle-panel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGroups > 0 || FALSE) { // Show footer ?>
</table>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php if ($Page->Export == "" && !($Page->DrillDown && $Page->TotalGroups > 0)) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php include "donation_user_wise_pager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<?php } ?>
<?php if ($Page->Export <> "pdf") { ?>
</div>
<?php } ?>
<!-- Summary Report Ends -->
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
</div>
<!-- /#ew-center -->
<?php } ?>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
</div>
<!-- /.row -->
<?php } ?>
<?php if ($Page->Export == "" && !$DashboardReport) { ?>
</div>
<!-- /.ew-container -->
<?php } ?>
<?php
$Page->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php

// Close recordsets
if ($Page->GroupRecordset)
	$Page->GroupRecordset->Close();
if ($Page->Recordset)
	$Page->Recordset->Close();
?>
<?php if ($Page->Export == "" && !$Page->DrillDown && !$DashboardReport) { ?>
<script>

// Write your table-specific startup script here
// console.log("page loaded");

</script>
<?php } ?>
<?php if (!$DashboardReport) { ?>
<?php include_once "rfooter.php" ?>
<?php } ?>
<?php
$Page->terminate();
if (isset($OldPage))
	$Page = $OldPage;
?>