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
if (!isset($event_status_wise_rpt))
	$event_status_wise_rpt = new event_status_wise_rpt();
if (isset($Page))
	$OldPage = $Page;
$Page = &$event_status_wise_rpt;

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
var fevent_status_wiserpt = currentForm = new ew.Form("fevent_status_wiserpt");

// Validate method
fevent_status_wiserpt.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj), elm;

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
fevent_status_wiserpt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}
<?php if (CLIENT_VALIDATE) { ?>
fevent_status_wiserpt.validateRequired = true; // Uses JavaScript validation
<?php } else { ?>
fevent_status_wiserpt.validateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
fevent_status_wiserpt.lists["x_event_status"] = <?php echo $event_status_wise_rpt->event_status->Lookup->toClientList() ?>;
fevent_status_wiserpt.lists["x_event_status"].options = <?php echo JsonEncode($event_status_wise_rpt->event_status->lookupOptions()) ?>;
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
<div id="ew-center" class="<?php echo $event_status_wise_rpt->CenterContentClass ?>">
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
<form name="fevent_status_wiserpt" id="fevent_status_wiserpt" class="form-inline ew-form ew-ext-filter-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($Page->Filter <> "") ? " show" : " show"; ?>
<div id="fevent_status_wiserpt-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ew-row d-sm-flex">
<div id="c_event_status" class="ew-cell form-group">
	<label for="x_event_status" class="ew-search-caption ew-label"><?php echo $Page->event_status->caption() ?></label>
	<span class="ew-search-field">
<?php $Page->event_status->EditAttrs["onchange"] = "ew.forms(this).submit(); " . @$Page->event_status->EditAttrs["onchange"]; ?>
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="event_status_wise" data-field="x_event_status" data-value-separator="<?php echo $Page->event_status->displayValueSeparatorAttribute() ?>" id="x_event_status" name="x_event_status"<?php echo $Page->event_status->editAttributes() ?>>
		<?php echo $Page->event_status->selectOptionListHtml("x_event_status") ?>
	</select>
</div>
<?php echo $Page->event_status->Lookup->getParamTag("p_x_event_status") ?>
</span>
</div>
</div>
</div>
</form>
<script>
fevent_status_wiserpt.filterList = <?php echo $Page->getFilterList() ?>;
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
<div id="gmp_event_status_wise" class="<?php if (IsResponsiveLayout()) { echo "table-responsive "; } ?>ew-grid-middle-panel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ew-table-header">
<?php if ($Page->event_activity_num->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_activity_num"><div class="event_status_wise_event_activity_num"><span class="ew-table-header-caption"><?php echo $Page->event_activity_num->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_activity_num">
<?php if ($Page->sortUrl($Page->event_activity_num) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_event_activity_num">
			<span class="ew-table-header-caption"><?php echo $Page->event_activity_num->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_event_activity_num" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_activity_num) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_activity_num->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_activity_num->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_activity_num->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->category_name->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="category_name"><div class="event_status_wise_category_name"><span class="ew-table-header-caption"><?php echo $Page->category_name->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="category_name">
<?php if ($Page->sortUrl($Page->category_name) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_category_name">
			<span class="ew-table-header-caption"><?php echo $Page->category_name->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_category_name" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->category_name) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->category_name->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->category_name->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->category_name->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_title->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_title"><div class="event_status_wise_event_title"><span class="ew-table-header-caption"><?php echo $Page->event_title->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_title">
<?php if ($Page->sortUrl($Page->event_title) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_event_title">
			<span class="ew-table-header-caption"><?php echo $Page->event_title->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_event_title" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_title) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_title->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_title->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_title->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_details->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_details"><div class="event_status_wise_event_details"><span class="ew-table-header-caption"><?php echo $Page->event_details->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_details">
<?php if ($Page->sortUrl($Page->event_details) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_event_details">
			<span class="ew-table-header-caption"><?php echo $Page->event_details->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_event_details" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_details) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_details->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_details->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_details->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_date->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_date"><div class="event_status_wise_event_date"><span class="ew-table-header-caption"><?php echo $Page->event_date->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_date">
<?php if ($Page->sortUrl($Page->event_date) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_event_date">
			<span class="ew-table-header-caption"><?php echo $Page->event_date->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_event_date" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_date) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_date->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_time->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_time"><div class="event_status_wise_event_time"><span class="ew-table-header-caption"><?php echo $Page->event_time->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_time">
<?php if ($Page->sortUrl($Page->event_time) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_event_time">
			<span class="ew-table-header-caption"><?php echo $Page->event_time->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_event_time" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_time) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_time->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_time->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_time->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_location->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_location"><div class="event_status_wise_event_location"><span class="ew-table-header-caption"><?php echo $Page->event_location->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_location">
<?php if ($Page->sortUrl($Page->event_location) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_event_location">
			<span class="ew-table-header-caption"><?php echo $Page->event_location->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_event_location" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_location) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_location->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_location->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_location->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_status->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_status"><div class="event_status_wise_event_status"><span class="ew-table-header-caption"><?php echo $Page->event_status->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_status">
<?php if ($Page->sortUrl($Page->event_status) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_event_status">
			<span class="ew-table-header-caption"><?php echo $Page->event_status->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_event_status" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_status) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_status->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_status->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_status->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->Last_Updated_By->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="Last_Updated_By"><div class="event_status_wise_Last_Updated_By"><span class="ew-table-header-caption"><?php echo $Page->Last_Updated_By->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="Last_Updated_By">
<?php if ($Page->sortUrl($Page->Last_Updated_By) == "") { ?>
		<div class="ew-table-header-btn event_status_wise_Last_Updated_By">
			<span class="ew-table-header-caption"><?php echo $Page->Last_Updated_By->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer event_status_wise_Last_Updated_By" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->Last_Updated_By) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->Last_Updated_By->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->Last_Updated_By->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->Last_Updated_By->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->event_activity_num->Visible) { ?>
		<td data-field="event_activity_num"<?php echo $Page->event_activity_num->cellAttributes() ?>>
<span<?php echo $Page->event_activity_num->viewAttributes() ?>><?php echo $Page->event_activity_num->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->category_name->Visible) { ?>
		<td data-field="category_name"<?php echo $Page->category_name->cellAttributes() ?>>
<span<?php echo $Page->category_name->viewAttributes() ?>><?php echo $Page->category_name->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_title->Visible) { ?>
		<td data-field="event_title"<?php echo $Page->event_title->cellAttributes() ?>>
<span<?php echo $Page->event_title->viewAttributes() ?>><?php echo $Page->event_title->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_details->Visible) { ?>
		<td data-field="event_details"<?php echo $Page->event_details->cellAttributes() ?>>
<span<?php echo $Page->event_details->viewAttributes() ?>><?php echo $Page->event_details->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_date->Visible) { ?>
		<td data-field="event_date"<?php echo $Page->event_date->cellAttributes() ?>>
<span<?php echo $Page->event_date->viewAttributes() ?>><?php echo $Page->event_date->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_time->Visible) { ?>
		<td data-field="event_time"<?php echo $Page->event_time->cellAttributes() ?>>
<span<?php echo $Page->event_time->viewAttributes() ?>><?php echo $Page->event_time->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_location->Visible) { ?>
		<td data-field="event_location"<?php echo $Page->event_location->cellAttributes() ?>>
<span<?php echo $Page->event_location->viewAttributes() ?>><?php echo $Page->event_location->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_status->Visible) { ?>
		<td data-field="event_status"<?php echo $Page->event_status->cellAttributes() ?>>
<span<?php echo $Page->event_status->viewAttributes() ?>><?php echo $Page->event_status->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->Last_Updated_By->Visible) { ?>
		<td data-field="Last_Updated_By"<?php echo $Page->Last_Updated_By->cellAttributes() ?>>
<span<?php echo $Page->Last_Updated_By->viewAttributes() ?>><?php echo $Page->Last_Updated_By->getViewValue() ?></span></td>
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
<div id="gmp_event_status_wise" class="<?php if (IsResponsiveLayout()) { echo "table-responsive "; } ?>ew-grid-middle-panel">
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
<?php include "event_status_wise_pager.php" ?>
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