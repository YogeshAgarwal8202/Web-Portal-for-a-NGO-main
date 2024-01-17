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
if (!isset($feedback_event_wise_rpt))
	$feedback_event_wise_rpt = new feedback_event_wise_rpt();
if (isset($Page))
	$OldPage = $Page;
$Page = &$feedback_event_wise_rpt;

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
var ffeedback_event_wiserpt = currentForm = new ew.Form("ffeedback_event_wiserpt");

// Validate method
ffeedback_event_wiserpt.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj), elm;

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate method
ffeedback_event_wiserpt.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}
<?php if (CLIENT_VALIDATE) { ?>
ffeedback_event_wiserpt.validateRequired = true; // Uses JavaScript validation
<?php } else { ?>
ffeedback_event_wiserpt.validateRequired = false; // No JavaScript validation
<?php } ?>

// Use Ajax
ffeedback_event_wiserpt.lists["x_event_title"] = <?php echo $feedback_event_wise_rpt->event_title->Lookup->toClientList() ?>;
ffeedback_event_wiserpt.autoSuggests["x_event_title"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
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
<div id="ew-center" class="<?php echo $feedback_event_wise_rpt->CenterContentClass ?>">
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
<form name="ffeedback_event_wiserpt" id="ffeedback_event_wiserpt" class="form-inline ew-form ew-ext-filter-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($Page->Filter <> "") ? " show" : " show"; ?>
<div id="ffeedback_event_wiserpt-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<div id="r_1" class="ew-row d-sm-flex">
<div id="c_event_title" class="ew-cell form-group">
	<label for="x_event_title" class="ew-search-caption ew-label"><?php echo $Page->event_title->caption() ?></label>
	<span class="ew-search-operator"><?php echo $ReportLanguage->phrase("="); ?><input type="hidden" name="z_event_title" id="z_event_title" value="="></span>
	<span class="control-group ew-search-field">
<?php
$wrkonchange = trim(" " . @$Page->event_title->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$Page->event_title->EditAttrs["onchange"] = "";
?>
<span id="as_x_event_title" class="text-nowrap" style="z-index: 8980">
	<input type="text" class="form-control" name="sv_x_event_title" id="sv_x_event_title" value="<?php echo RemoveHtml($Page->event_title->AdvancedSearch->SearchValue) ?>" size="30" maxlength="60" placeholder="<?php echo HtmlEncode($Page->event_title->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($Page->event_title->getPlaceHolder()) ?>"<?php echo $Page->event_title->editAttributes() ?>>
</span>
<input type="hidden" data-table="feedback_event_wise" data-field="x_event_title" data-value-separator="<?php echo $Page->event_title->displayValueSeparatorAttribute() ?>" name="x_event_title" id="x_event_title" value="<?php echo HtmlEncode($Page->event_title->AdvancedSearch->SearchValue) ?>"<?php echo $wrkonchange ?>>
<script>
ffeedback_event_wiserpt.createAutoSuggest({"id":"x_event_title","forceSelect":false});
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
ffeedback_event_wiserpt.filterList = <?php echo $Page->getFilterList() ?>;
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
<div id="gmp_feedback_event_wise" class="<?php if (IsResponsiveLayout()) { echo "table-responsive "; } ?>ew-grid-middle-panel">
<?php } ?>
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ew-table-header">
<?php if ($Page->feedback_id->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="feedback_id"><div class="feedback_event_wise_feedback_id"><span class="ew-table-header-caption"><?php echo $Page->feedback_id->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="feedback_id">
<?php if ($Page->sortUrl($Page->feedback_id) == "") { ?>
		<div class="ew-table-header-btn feedback_event_wise_feedback_id">
			<span class="ew-table-header-caption"><?php echo $Page->feedback_id->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer feedback_event_wise_feedback_id" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->feedback_id) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->feedback_id->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->feedback_id->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->feedback_id->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_title->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_title"><div class="feedback_event_wise_event_title"><span class="ew-table-header-caption"><?php echo $Page->event_title->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_title">
<?php if ($Page->sortUrl($Page->event_title) == "") { ?>
		<div class="ew-table-header-btn feedback_event_wise_event_title">
			<span class="ew-table-header-caption"><?php echo $Page->event_title->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer feedback_event_wise_event_title" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_title) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_title->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_title->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_title->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->feedback_description->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="feedback_description"><div class="feedback_event_wise_feedback_description"><span class="ew-table-header-caption"><?php echo $Page->feedback_description->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="feedback_description">
<?php if ($Page->sortUrl($Page->feedback_description) == "") { ?>
		<div class="ew-table-header-btn feedback_event_wise_feedback_description">
			<span class="ew-table-header-caption"><?php echo $Page->feedback_description->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer feedback_event_wise_feedback_description" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->feedback_description) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->feedback_description->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->feedback_description->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->feedback_description->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->feedback_date->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="feedback_date"><div class="feedback_event_wise_feedback_date"><span class="ew-table-header-caption"><?php echo $Page->feedback_date->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="feedback_date">
<?php if ($Page->sortUrl($Page->feedback_date) == "") { ?>
		<div class="ew-table-header-btn feedback_event_wise_feedback_date">
			<span class="ew-table-header-caption"><?php echo $Page->feedback_date->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer feedback_event_wise_feedback_date" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->feedback_date) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->feedback_date->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->feedback_date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->feedback_date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->feedback_time->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="feedback_time"><div class="feedback_event_wise_feedback_time"><span class="ew-table-header-caption"><?php echo $Page->feedback_time->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="feedback_time">
<?php if ($Page->sortUrl($Page->feedback_time) == "") { ?>
		<div class="ew-table-header-btn feedback_event_wise_feedback_time">
			<span class="ew-table-header-caption"><?php echo $Page->feedback_time->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer feedback_event_wise_feedback_time" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->feedback_time) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->feedback_time->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->feedback_time->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->feedback_time->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->user_name->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="user_name"><div class="feedback_event_wise_user_name"><span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="user_name">
<?php if ($Page->sortUrl($Page->user_name) == "") { ?>
		<div class="ew-table-header-btn feedback_event_wise_user_name">
			<span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer feedback_event_wise_user_name" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->user_name) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->user_name->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->user_name->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->user_name->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_date->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_date"><div class="feedback_event_wise_event_date"><span class="ew-table-header-caption"><?php echo $Page->event_date->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_date">
<?php if ($Page->sortUrl($Page->event_date) == "") { ?>
		<div class="ew-table-header-btn feedback_event_wise_event_date">
			<span class="ew-table-header-caption"><?php echo $Page->event_date->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer feedback_event_wise_event_date" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_date) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_date->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_date->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_date->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->event_location->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="event_location"><div class="feedback_event_wise_event_location"><span class="ew-table-header-caption"><?php echo $Page->event_location->caption() ?></span></div></td>
<?php } else { ?>
	<td data-field="event_location">
<?php if ($Page->sortUrl($Page->event_location) == "") { ?>
		<div class="ew-table-header-btn feedback_event_wise_event_location">
			<span class="ew-table-header-caption"><?php echo $Page->event_location->caption() ?></span>
		</div>
<?php } else { ?>
		<div class="ew-table-header-btn ew-pointer feedback_event_wise_event_location" onclick="ew.sort(event,'<?php echo $Page->sortUrl($Page->event_location) ?>',2);">
			<span class="ew-table-header-caption"><?php echo $Page->event_location->caption() ?></span>
			<span class="ew-table-header-sort"><?php if ($Page->event_location->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($Page->event_location->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span>
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
<?php if ($Page->feedback_id->Visible) { ?>
		<td data-field="feedback_id"<?php echo $Page->feedback_id->cellAttributes() ?>>
<span<?php echo $Page->feedback_id->viewAttributes() ?>><?php echo $Page->feedback_id->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_title->Visible) { ?>
		<td data-field="event_title"<?php echo $Page->event_title->cellAttributes() ?>>
<span<?php echo $Page->event_title->viewAttributes() ?>><?php echo $Page->event_title->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->feedback_description->Visible) { ?>
		<td data-field="feedback_description"<?php echo $Page->feedback_description->cellAttributes() ?>>
<span<?php echo $Page->feedback_description->viewAttributes() ?>><?php echo $Page->feedback_description->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->feedback_date->Visible) { ?>
		<td data-field="feedback_date"<?php echo $Page->feedback_date->cellAttributes() ?>>
<span<?php echo $Page->feedback_date->viewAttributes() ?>><?php echo $Page->feedback_date->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->feedback_time->Visible) { ?>
		<td data-field="feedback_time"<?php echo $Page->feedback_time->cellAttributes() ?>>
<span<?php echo $Page->feedback_time->viewAttributes() ?>><?php echo $Page->feedback_time->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->user_name->Visible) { ?>
		<td data-field="user_name"<?php echo $Page->user_name->cellAttributes() ?>>
<span<?php echo $Page->user_name->viewAttributes() ?>><?php echo $Page->user_name->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_date->Visible) { ?>
		<td data-field="event_date"<?php echo $Page->event_date->cellAttributes() ?>>
<span<?php echo $Page->event_date->viewAttributes() ?>><?php echo $Page->event_date->getViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->event_location->Visible) { ?>
		<td data-field="event_location"<?php echo $Page->event_location->cellAttributes() ?>>
<span<?php echo $Page->event_location->viewAttributes() ?>><?php echo $Page->event_location->getViewValue() ?></span></td>
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
<div id="gmp_feedback_event_wise" class="<?php if (IsResponsiveLayout()) { echo "table-responsive "; } ?>ew-grid-middle-panel">
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
<?php include "feedback_event_wise_pager.php" ?>
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