@section('cssAfterMain')
<style>
  .debug {
    box-shadow: 0 0 0 1px red;
  }
  .grayscale {
    filter: grayscale(100);
  }

  .font-arial {
    font-family: "Arial";
  }

  .font-calibri {
    font-family: "Calibri";
  }

  .font-tradisional {
    font-family: "Times New Roman";
  }

  .font-pt-10 {
    font-size: 10pt !important;
  }

  .font-pt-11 {
    font-size: 11pt !important;
  }

  .font-pt-12 {
    font-size: 12pt !important;
  }

  .font-pt-14 {
    font-size: 14pt !important;
  }

  .font-pt-15 {
    font-size: 15pt !important;
  }

  .font-pt-16 {
    font-size: 16pt !important;
  }

  .font-pt-18 {
    font-size: 18pt !important;
  }

  .font-pt-20 {
    font-size: 20pt !important;
  }

  .font-pt-21 {
    font-size: 21pt !important;
  }

  .font-pt-22 {
    font-size: 22pt !important;
  }

  .lineheight-1-25 {
    line-height: 1.25em;
  }

  .lineheight-1 {
    line-height: 1em;
  }

  .lineheight-1-5 {
    line-height: 1.5em;
  }

  .no-spacing {
    border-spacing: 0;
  }

  .table-hitam {
    border: 1px solid #000000;
    margin-bottom: 0;
    color: #000000 !important;
  }
  
  .table-hitam th,
  .table-hitam td {
    padding: .5rem !important;
    border: 1px solid #000000;
  }

  .table-hitam.table-asn th,
  .table-hitam.table-asn td {
    padding: .15rem .25rem !important;
    border: 1px solid #000000;
  }

  .table-voting th,
  .table-voting td {
    padding: .25rem .25rem !important;
    border: 1px solid rgba(0, 0, 0, 0.207);
  }

  .table-hitam thead th,
  .table-hitam thead td {
    border-bottom-width: 2px;
  }

  .table-hitam thead.bb1 th,
  .table-hitam thead.bb1 td {
    border-bottom-width: 1px;
  }

  .table-hitam.no-border,
  .table-hitam.no-border th,
  .table-hitam.no-border td {
    border: none;
  }
  th.tp-1 {
    padding: .25rem !important;
  }

  .table-hitam.sm-padding th,
  .table-hitam.sm-padding td {
    padding: .25rem !important;
  }

  .bt-l {
    border-left: 1px solid #000000;
  }
  .bt-t {
      border-top: 1px solid #000000;
  }
  .bt-r {
      border-right: 1px solid #000000;
  }
  .bt-b {
      border-bottom: 1px solid #000000;
  }

  .text-center {
    text-align: center;
  }

  .fw-600 {
    font-weight: 600;
  }

  .fw-700 {
    font-weight: 700;
  }

  .fw-800 {
    font-weight: 800;
  }

  .valign-top {
    vertical-align: top !important;
  }

  .td-child-top > td {
    vertical-align: top !important;
  }

  .w-100 {
    width: 100%;
  }

  @media not print {
    .print-area:not(.in-pdf) {
      position: fixed;
      top: 0;
      left: 0;
      display: none !important;
    }
  }

  @media print {
    body {
      background: #ffffff;
      color: #000000 !important;
    }

    body>*:not(.print-area),
    body>*:not(.print-area) * {
      display: none !important;
    }
  }
  body.pdf-printed {
    background: #ffffff !important;
    color: #000000 !important;
  }

  body.pdf-printed>*:not(.print-area),
  body.pdf-printed>*:not(.print-area) * {
    display: none !important;
  }
</style>
@parent
@endsection