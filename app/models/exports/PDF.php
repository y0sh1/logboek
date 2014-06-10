<?php

namespace Exports;

use Entry;
use Logbook;

use File;
use View;
use PDF as DOMPDF;

class PDF extends \Export {

	protected $content_type = 'application/pdf';
	protected $extension = 'pdf';

	public function __construct(array $attributes = array()) {
		parent::__construct($attributes);
		$this->type = 'pdf';
	}

	public $pdf;

	private function getView() {
		return View::make('pdfs.report', [
			'title' => 'IPFIT1 groep 2',
			'logbooks' => Logbook::all(),
			'generated_at' => date('d-m-Y H:i'),
		]);
	}

	private function generatePDF() {
		$view = $this->getView();
		$html = $view->render();

		try {
			$pdf = DOMPDF::load($html, 'A4', 'portrait')->output();
		} catch(\Exception $e) {
			$filename = '/tmp/'.$this->generateFilename().'.html';
			file_put_contents($filename, $html);
			throw $e;
		}

		return $pdf;
	}

	public function run($save = true) {
		$pdf = $this->generatePDF();
		if($save) {
			if(!File::put($this->fullPath(), $pdf))
				return false;

			$this->updateFileSize();
		} else {
			$this->pdf = $pdf;
			$this->filesize = 0;
		}

		return true;
	}

}
