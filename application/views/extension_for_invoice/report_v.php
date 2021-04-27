<!DOCTYPE html>
<html lang="en" style="box-sizing: border-box;font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;-webkit-tap-highlight-color: transparent;">
<head style="box-sizing: border-box;">
  <title style="box-sizing: border-box;"><?php echo $data["title"] ?></title>
  <meta charset="utf-8" style="box-sizing: border-box;">
  <meta name="viewport" content="width=device-width, initial-scale=1" style="box-sizing: border-box;">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" style="box-sizing: border-box;"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" style="box-sizing: border-box;"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" style="box-sizing: border-box;"></script>

</head>
<body class="bg-light" style="box-sizing: border-box;margin: 0;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,&quot;Noto Sans&quot;,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;,&quot;Noto Color Emoji&quot;;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;text-align: left;background-color: #f8f9fa!important;min-width: 992px!important;">


  <div class="container MaWi_800px Preset_card mt-5" style="box-sizing: border-box;width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;max-width: 800px;position: relative;min-width: 992px!important;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0,0,0,.125);border-radius: .25rem;margin-top: 3rem!important;">
    <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
      <div class="col-md-4 mt-5" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;margin-top: 3rem!important;">

      </div>
      <div class="col-md-4 mt-5" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;margin-top: 3rem!important;">
        <h1 class="text-center" style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 2.5rem;text-align: center!important;">
          <?php echo $data["title"]; ?>
        </h1>
      </div>
      <div class="col-md-4 mt-5" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;margin-top: 3rem!important;">

      </div>
    </div>
    <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
      <div class="col-md-12" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;">
        <hr style="background-color: black;color: black;height: 1px;box-sizing: content-box;overflow: visible;margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0,0,0,.1);">
      </div>
    </div>
    <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
      <div class="col-md-12 mt-5" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;margin-top: 3rem!important;">
        <h2 class="text-center" style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 2rem;orphans: 3;widows: 3;page-break-after: avoid;text-align: center!important;">
          overview
        </h2>
        <hr style="background-color: black;color: black;height: 1px;box-sizing: content-box;overflow: visible;margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0,0,0,.1);">
      </div>
    </div>
    <table class="table" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;margin-bottom: 1rem;color: #212529;">
      <tr style="box-sizing: border-box;page-break-inside: avoid;">
        <?php if (isset($data["invoice"][0])): ?>
          <?php foreach ($data["invoice"][0] as $key => $value): ?>
            <th style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">
              <?php echo $key ?>
            </th>
          <?php endforeach; ?>
        <?php endif; ?>
      </tr>
      <?php foreach ($data["invoice"] as $key => $value): ?>
        <tr style="box-sizing: border-box;page-break-inside: avoid;">
          <?php foreach ($value as $key2 => $value2): ?>
            <td style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">
              <?php echo $value2 ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </table>

    <div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
      <div class="col-md-12 mt-5" style="box-sizing: border-box;position: relative;width: 100%;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 100%;flex: 0 0 100%;max-width: 100%;margin-top: 3rem!important;">
        <h2 class="text-center" style="box-sizing: border-box;margin-top: 0;margin-bottom: .5rem;font-weight: 500;line-height: 1.2;font-size: 2rem;orphans: 3;widows: 3;page-break-after: avoid;text-align: center!important;">
          invoiced transactions
        </h2>
        <hr style="background-color: black;color: black;height: 1px;box-sizing: content-box;overflow: visible;margin-top: 1rem;margin-bottom: 1rem;border: 0;border-top: 1px solid rgba(0,0,0,.1);">
      </div>
    </div>

    <table class="table" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;margin-bottom: 1rem;color: #212529;">
      <tr style="box-sizing: border-box;page-break-inside: avoid;">
        <?php if (isset($data["invoiced_transactions"][0])): ?>
          <?php foreach ($data["invoiced_transactions"][0] as $key => $value): ?>
            <th style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">
              <?php echo $key ?>
            </th>
          <?php endforeach; ?>
        <?php endif; ?>
      </tr>
      <?php foreach ($data["invoiced_transactions"] as $key => $value): ?>
        <tr style="box-sizing: border-box;page-break-inside: avoid;">
          <?php foreach ($value as $key2 => $value2): ?>
            <td style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">
              <?php echo $value2 ?>
            </td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </table>

    </div>

  </body>
  </html>
