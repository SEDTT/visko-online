<?php
require_once 'JsonCerializable.php';
require_once 'JsonDeserializable.php';

/**
 * A record for the query objects received from ViskoBackend.
 * Has text (vsql) or alternatively
 * several fields.
 * 
 * @author awknaust
 *        
 */
class ViskoQuery implements JsonCerializable, JsonDeserializable {
	private $vsql;
	private $targetFormatURI;
	private $targetTypeURI;
	private $viewURI;
	private $viewerSetURI;
	private $artifactURL;
	private $parameterBindings;
	private $formatURI;
	private $typeURI;

	public function __construct() {
	}

	public function init($vsql, $formatURI, $typeURI, $targetFormatURI, $targetTypeURI, $viewURI, $viewerSetURI, $artifactURL, $parameterBindings) {
		$this->setQueryText ( $vsql );
		$this->formatURI = $formatURI;
		$this->typeURI = $typeURI;
		$this->targetFormatURI = $targetFormatURI;
		$this->targetTypeURI = $targetTypeURI;
		$this->viewURI = $viewURI;
		$this->viewerSetURI = $viewerSetURI;
		$this->artifactURL = $artifactURL;
		$this->parameterBindings = $parameterBindings;
	}

	public function getQueryText() {
		return $this->vsql;
	}

	public function getFormatURI() {
		return $this->formatURI;
	}

	public function getTypeURI() {
		return $this->typeURI;
	}

	public function getArtifactURL() {
		return $this->artifactURL;
	}

	public function getTargetFormatURI() {
		return $this->targetFormatURI;
	}

	public function getTargetTypeURI() {
		return $this->targetTypeURI;
	}

	public function getViewURI() {
		return $this->viewURI;
	}

	public function getViewerSetURI() {
		return $this->viewerSetURI;
	}

	public function setQueryText($queryText) {
		$this->vsql = trim ( $queryText );
	}

	public function getParameterBindings() {
		return $this->parameterBindings;
	}

	/**
	 * Convert to JSON using either the query text or the parameters.
	 */
	public function toJson() {
		if ($this->vsql != null) {
			$attrs = array (
					"type" => "Query",
					"vsql" => $this->vsql 
			);
		} else {
			$attrs = array (
					"type" => "Query",
					"formatURI" => $this->formatURI,
					"typeURI" => $this->typeURI,
					"artifactURL" => $this->artifactURL,
					"targetTypeURI" => $this->targetTypeURI,
					"targetFormatURI" => $this->targetFormatURI,
					"viewURI" => $this->viewURI,
					"viewerSetURI" => $this->viewerSetURI 
			);
		}
		return $attrs;
	}

	public function fromJson($json) {
		$this->vsql = $json->vsql;
		$this->formatURI = $json->formatURI;
		$this->typeURI = $json->typeURI;
		$this->targetFormatURI = $json->targetFormatURI;
		$this->targetTypeURI = $json->targetTypeURI;
		$this->viewURI = $json->viewURI;
		$this->viewerSetURI = $json->viewerSetURI;
		$this->artifactURL = $json->artifactURL;
		
		// weird php hack to get object fields as assoc array
		$this->parameterBindings = get_object_vars ( $json->parameterBindings );
	}
}
