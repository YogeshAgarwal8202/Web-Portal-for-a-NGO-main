<?php
namespace PHPReportMaker12\sss;

/**
 * Table class for volunteer event wise
 */
class volunteer_event_wise_base extends ReportTable
{
	public $ShowGroupHeaderAsRow = FALSE;
	public $ShowCompactSummaryFooter = TRUE;
	public $volunteer_id;
	public $user_name;
	public $user_gender;
	public $user_email;
	public $user_mobile;
	public $user_country_code;
	public $user_blood_group;
	public $event_activity_num;
	public $event_title;
	public $event_date;
	public $event_time;
	public $event_location;
	public $category_name;

	// Constructor
	public function __construct()
	{
		global $ReportLanguage, $CurrentLanguage;

		// Language object
		if (!isset($ReportLanguage))
			$ReportLanguage = new ReportLanguage();
		$this->TableVar = 'volunteer_event_wise_base';
		$this->TableName = 'volunteer event wise';
		$this->TableType = 'VIEW';
		$this->TableReportType = 'rpt';
		$this->SourceTableIsCustomView = FALSE;
		$this->Dbid = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// volunteer_id
		$this->volunteer_id = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_volunteer_id', 'volunteer_id', '`volunteer_id`', 20, -1, FALSE, 'FORMATTED TEXT', 'NO');
		$this->volunteer_id->Sortable = FALSE; // Allow sort
		$this->volunteer_id->DefaultErrorMessage = $ReportLanguage->phrase("IncorrectInteger");
		$this->volunteer_id->DateFilter = "";
		$this->fields['volunteer_id'] = &$this->volunteer_id;

		// user_name
		$this->user_name = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_user_name', 'user_name', '`user_name`', 200, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_name->Sortable = FALSE; // Allow sort
		$this->user_name->DateFilter = "";
		$this->fields['user_name'] = &$this->user_name;

		// user_gender
		$this->user_gender = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_user_gender', 'user_gender', '`user_gender`', 200, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_gender->Sortable = FALSE; // Allow sort
		$this->user_gender->DateFilter = "";
		$this->fields['user_gender'] = &$this->user_gender;

		// user_email
		$this->user_email = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_user_email', 'user_email', '`user_email`', 200, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_email->Sortable = FALSE; // Allow sort
		$this->user_email->DateFilter = "";
		$this->fields['user_email'] = &$this->user_email;

		// user_mobile
		$this->user_mobile = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_user_mobile', 'user_mobile', '`user_mobile`', 20, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_mobile->Sortable = FALSE; // Allow sort
		$this->user_mobile->DefaultErrorMessage = $ReportLanguage->phrase("IncorrectInteger");
		$this->user_mobile->DateFilter = "";
		$this->fields['user_mobile'] = &$this->user_mobile;

		// user_country_code
		$this->user_country_code = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_user_country_code', 'user_country_code', '`user_country_code`', 200, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_country_code->Sortable = FALSE; // Allow sort
		$this->user_country_code->DateFilter = "";
		$this->fields['user_country_code'] = &$this->user_country_code;

		// user_blood_group
		$this->user_blood_group = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_user_blood_group', 'user_blood_group', '`user_blood_group`', 200, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->user_blood_group->Sortable = FALSE; // Allow sort
		$this->user_blood_group->DateFilter = "";
		$this->fields['user_blood_group'] = &$this->user_blood_group;

		// event_activity_num
		$this->event_activity_num = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_event_activity_num', 'event_activity_num', '`event_activity_num`', 20, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->event_activity_num->Sortable = FALSE; // Allow sort
		$this->event_activity_num->DefaultErrorMessage = $ReportLanguage->phrase("IncorrectInteger");
		$this->event_activity_num->DateFilter = "";
		$this->fields['event_activity_num'] = &$this->event_activity_num;

		// event_title
		$this->event_title = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_event_title', 'event_title', '`event_title`', 200, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->event_title->Sortable = FALSE; // Allow sort
		$this->event_title->DateFilter = "";
		$this->event_title->Lookup = new ReportLookup('event_title', 'volunteer_event_wise_base', TRUE, 'event_title', ["event_title","","",""], [], [], [], [], [], [], '`event_title` ASC', '');
		$this->event_title->Lookup->RenderViewFunc = "renderLookup";
		$this->fields['event_title'] = &$this->event_title;

		// event_date
		$this->event_date = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_event_date', 'event_date', '`event_date`', 133, 7, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->event_date->Sortable = FALSE; // Allow sort
		$this->event_date->DefaultErrorMessage = $ReportLanguage->phrase("IncorrectField");
		$this->event_date->DateFilter = "";
		$this->fields['event_date'] = &$this->event_date;

		// event_time
		$this->event_time = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_event_time', 'event_time', '`event_time`', 134, 4, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->event_time->Sortable = FALSE; // Allow sort
		$this->event_time->DefaultErrorMessage = str_replace("%s", $GLOBALS["TIME_SEPARATOR"], $ReportLanguage->phrase("IncorrectTime"));
		$this->event_time->DateFilter = "";
		$this->fields['event_time'] = &$this->event_time;

		// event_location
		$this->event_location = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_event_location', 'event_location', '`event_location`', 200, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->event_location->Sortable = FALSE; // Allow sort
		$this->event_location->DateFilter = "";
		$this->fields['event_location'] = &$this->event_location;

		// category_name
		$this->category_name = new ReportField('volunteer_event_wise_base', 'volunteer event wise', 'x_category_name', 'category_name', '`category_name`', 200, -1, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->category_name->Sortable = FALSE; // Allow sort
		$this->category_name->DateFilter = "";
		$this->fields['category_name'] = &$this->category_name;
	}

	// Render for popup
	public function renderPopup()
	{
		global $ReportLanguage;
	}

	// Render for lookup
	public function renderLookup()
	{
		$this->event_title->ViewValue = $this->event_title->CurrentValue;
	}

	// Get Field Visibility
	public function getFieldVisibility($fldparm)
	{
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Multiple column sort
	protected function updateSort(&$fld, $ctrl)
	{
		if ($this->CurrentOrder == $fld->Name) {
			$sortField = $fld->Expression;
			$lastSort = $fld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$thisSort = $this->CurrentOrderType;
			} else {
				$thisSort = ($lastSort == "ASC") ? "DESC" : "ASC";
			}
			$fld->setSort($thisSort);
			if ($fld->GroupingFieldId == 0) {
				if ($ctrl) {
					$orderBy = $this->getDetailOrderBy();
					if (strpos($orderBy, $sortField . " " . $lastSort) !== FALSE) {
						$orderBy = str_replace($sortField . " " . $lastSort, $sortField . " " . $thisSort, $orderBy);
					} else {
						if ($orderBy <> "") $orderBy .= ", ";
						$orderBy .= $sortField . " " . $thisSort;
					}
					$this->setDetailOrderBy($orderBy); // Save to Session
				} else {
					$this->setDetailOrderBy($sortField . " " . $thisSort); // Save to Session
				}
			}
		} else {
			if ($fld->GroupingFieldId == 0 && !$ctrl) $fld->setSort("");
		}
	}

	// Get Sort SQL
	protected function sortSql()
	{
		$dtlSortSql = $this->getDetailOrderBy(); // Get ORDER BY for detail fields from session
		$argrps = [];
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				$fldsql = $fld->Expression;
				if ($fld->GroupingFieldId > 0) {
					if ($fld->GroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fldsql, $fld->GroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fldsql . " " . $fld->getSort();
				}
			}
		}
		$sortSql = "";
		foreach ($argrps as $grp) {
			if ($sortSql <> "") $sortSql .= ", ";
			$sortSql .= $grp;
		}
		if ($dtlSortSql <> "") {
			if ($sortSql <> "") $sortSql .= ", ";
			$sortSql .= $dtlSortSql;
		}
		return $sortSql;
	}

	// Table level SQL
	private $_sqlFrom = "";
	private $_sqlSelect = "";
	private $_sqlWhere = "";
	private $_sqlGroupBy = "";
	private $_sqlHaving = "";
	private $_sqlOrderBy = "";

	// From
	public function getSqlFrom()
	{
		return ($this->_sqlFrom <> "") ? $this->_sqlFrom : "`volunteer event wise`";
	}
	public function setSqlFrom($v)
	{
		$this->_sqlFrom = $v;
	}

	// Select
	public function getSqlSelect()
	{
		return ($this->_sqlSelect <> "") ? $this->_sqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}
	public function setSqlSelect($v)
	{
		$this->_sqlSelect = $v;
	}

	// Where
	public function getSqlWhere()
	{
		$where = ($this->_sqlWhere <> "") ? $this->_sqlWhere : "";
		$filter = "";
		AddFilter($where, $filter);
		return $where;
	}
	public function setSqlWhere($v)
	{
		$this->_sqlWhere = $v;
	}

	// Group By
	public function getSqlGroupBy()
	{
		return ($this->_sqlGroupBy <> "") ? $this->_sqlGroupBy : "";
	}
	public function setSqlGroupBy($v)
	{
		$this->_sqlGroupBy = $v;
	}

	// Having
	public function getSqlHaving()
	{
		return ($this->_sqlHaving <> "") ? $this->_sqlHaving : "";
	}
	public function setSqlHaving($v)
	{
		$this->_sqlHaving = $v;
	}

	// Order By
	public function getSqlOrderBy()
	{
		return ($this->_sqlOrderBy <> "") ? $this->_sqlOrderBy : "";
	}
	public function setSqlOrderBy($v)
	{
		$this->_sqlOrderBy = $v;
	}

	// Get SQL
	public function getSql($where, $orderBy = "")
	{
		return BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderBy);
	}

	// Summary properties
	private $_sqlSelectAggregate = "";
	private $_sqlAggregatePrefix = "";
	private $_sqlAggregateSuffix = "";
	private $_sqlSelectCount = "";

	// Select Aggregate
	public function getSqlSelectAggregate()
	{
		return ($this->_sqlSelectAggregate <> "") ? $this->_sqlSelectAggregate : "SELECT * FROM " . $this->getSqlFrom();
	}
	public function setSqlSelectAggregate($v)
	{
		$this->_sqlSelectAggregate = $v;
	}

	// Aggregate Prefix
	public function getSqlAggregatePrefix()
	{
		return ($this->_sqlAggregatePrefix <> "") ? $this->_sqlAggregatePrefix : "";
	}
	public function setSqlAggregatePrefix($v)
	{
		$this->_sqlAggregatePrefix = $v;
	}

	// Aggregate Suffix
	public function getSqlAggregateSuffix()
	{
		return ($this->_sqlAggregateSuffix <> "") ? $this->_sqlAggregateSuffix : "";
	}
	public function setSqlAggregateSuffix($v)
	{
		$this->_sqlAggregateSuffix = $v;
	}

	// Select Count
	public function getSqlSelectCount()
	{
		return ($this->_sqlSelectCount <> "") ? $this->_sqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}
	public function setSqlSelectCount($v)
	{
		$this->_sqlSelectCount = $v;
	}

	// Get record count
	public function getRecordCount($sql)
	{
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';

		// Skip Custom View / SubQuery and SELECT DISTINCT
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
			preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) && !preg_match('/^\s*select\s+distinct\s+/i', $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
		} else {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
		}
		$conn = &$this->getConnection();
		if ($rs = $conn->execute($sqlwrk)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->close();
			}
			return (int)$cnt;
		}

		// Unable to get count, get record count directly
		if ($rs = $conn->execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->close();
			return (int)$cnt;
		}
		return $cnt;
	}

	// Get recordset
	public function getRecordset($sql, $rowcnt = -1, $offset = -1)
	{
		$conn = &$this->getConnection();
		$conn->raiseErrorFn = $GLOBALS["ERROR_FUNC"];
		$rs = $conn->selectLimit($sql, $rowcnt, $offset);
		$conn->raiseErrorFn = '';
		return $rs;
	}

	// Sort URL
	public function sortUrl(&$fld)
	{
		global $DashboardReport;
		if ($this->isExport() || $DashboardReport ||
			in_array($fld->Type, [128, 204, 205])) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {

			//$urlParm = "order=" . urlencode($fld->Name) . "&ordertype=" . $fld->reverseSort();
			$urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->reverseSort();
			return CurrentPageName() . "?" . $urlParm;
		} else {
			return "";
		}
	}

	// Lookup data from table
	public function lookup()
	{

		// Load lookup parameters
		$distinct = ConvertToBool(Post("distinct"));
		$linkField = Post("linkField");
		$displayFields = Post("displayFields");
		$parentFields = Post("parentFields");
		if (!is_array($parentFields))
			$parentFields = [];
		$childFields = Post("childFields");
		if (!is_array($childFields))
			$childFields = [];
		$filterFields = Post("filterFields");
		if (!is_array($filterFields))
			$filterFields = [];
		$filterFieldVars = Post("filterFieldVars");
		if (!is_array($filterFieldVars))
			$filterFieldVars = [];
		$filterOperators = Post("filterOperators");
		if (!is_array($filterOperators))
			$filterOperators = [];
		$autoFillSourceFields = Post("autoFillSourceFields");
		if (!is_array($autoFillSourceFields))
			$autoFillSourceFields = [];
		$formatAutoFill = FALSE;
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Get("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = AUTO_SUGGEST_MAX_ENTRIES;
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));

		// Create lookup object and output JSON
		$lookup = new ReportLookup($linkField, $this->TableVar, $distinct, $linkField, $displayFields, $parentFields, $childFields, $filterFields, $filterFieldVars, $autoFillSourceFields);
		foreach ($filterFields as $i => $filterField) { // Set up filter operators
			if (@$filterOperators[$i] <> "")
				$lookup->setFilterOperator($filterField, $filterOperators[$i]);
		}
		$lookup->LookupType = $lookupType; // Lookup type
		if (Post("keys") !== NULL) { // Selected records from modal
			$keys = Post("keys");
			if (is_array($keys))
				$keys = implode(LOOKUP_FILTER_VALUE_SEPARATOR, $keys);
			$lookup->FilterValues[] = $keys; // Lookup values
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($filterFields) ? count($filterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect <> "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter <> "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy <> "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson();
	}

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = THUMBNAIL_DEFAULT_WIDTH, $height = THUMBNAIL_DEFAULT_HEIGHT)
	{

		// No binary fields
		return FALSE;
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["class"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', PROJECT_NAMESPACE . 'GetStartsWithAFilter'); // With function, or
		//RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		//if ($typ == "dropdown" && $fld->Name == "MyField") // Dropdown filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "extended" && $fld->Name == "MyField") // Extended filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "popup" && $fld->Name == "MyField") // Popup filter
		//	$filter = "..."; // Modify the filter
		//if ($typ == "custom" && $opr == "..." && $fld->Name == "MyField") // Custom filter, $opr is the custom filter ID
		//	$filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>