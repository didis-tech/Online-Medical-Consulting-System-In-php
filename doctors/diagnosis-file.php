<!DOCTYPE html>
<html lang="en">


<body  style="color: #000; font-size: 16px; text-decoration: none; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #efefef;">
  <style>
  div.card {
  width: 80%;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  text-align: center;
  }


  /*-----------------
  24. Invoice
  -----------------------*/

  .invoice-details,
  .invoice-payment-details > li span {
  float: right;
  text-align: right;
  }
  .attach-files > ul {
  list-style: none;
  margin: 0;
  padding: 0;
  }
  .attach-files li {
  display: inline-block;
  margin-right: 10px;
  position: relative;
  }
  .attach-files li img {
  width: 50px;
  }
  .file-remove {
  color: #f00;
  position: absolute;
  right: -6px;
  top: -7px;
  }
  .attach-files li:last-child {
  margin-right: 0;
  }
  .inv-logo {
  height: auto;
  margin-bottom: 20px;
  max-height: 100px;
  width: auto;
  }
  ol,
  ul,
  dl {
  margin-top: 0;
  margin-bottom: 1rem;
  }

  ol ol,
  ul ul,
  ol ul,
  ul ol {
  margin-bottom: 0;
  }
  table, td, th {
  border: 1px solid #ddd;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 15px;
}
  .m-b-20 {
      margin-bottom: 20px !important;
  }
  .list-unstyled {
  padding-left: 0;
  list-style: none;
  }

  * {
      box-sizing: border-box;
  }
  .header {
      border: 1px solid red;
      padding: 15px;
  }
  .row::after {
      content: "";
      clear: both;
      display: table;
  }
  [class*="col-"] {
      float: left;
      padding: 15px;
  }
  .col-1 {width: 8.33%;}
  .col-2 {width: 16.66%;}
  .col-3 {width: 25%;}
  .col-4 {width: 33.33%;}
  .col-5 {width: 41.66%;}
  .col-6 {width: 50%;}
  .col-7 {width: 58.33%;}
  .col-8 {width: 66.66%;}
  .col-9 {width: 75%;}
  .col-10 {width: 83.33%;}
  .col-11 {width: 91.66%;}
  .col-12 {width: 100%;}
  .btn {
  background-color: purple; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
}

.button1 {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}

.btn:hover {
  box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
}
  </style>
    <div class="main-wrapper">


        <div class="page-wrapper">
            <div class="content">
              <div class="row">
                  <div class="col-12">
                      <center>
                        <div  style="
                        width: 80%;
                        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                        text-align: center;">
                            <div class="card-body">
                                <div class="row custom-invoice">
                                    <div class="col-6 col-sm-6 m-b-20" style="left:0px">
                                        <img src="{CUSTOM_IMG}" class="inv-logo" alt="">
                                        <ul class="list-unstyled">
                                            <li>E-Diagnosis</li>
                                            <li>GST No: 08143307959</li>
                                        </ul>
                                    </div>
                                    <div class="col-6 col-sm-6 m-b-20">
                                        <div class="invoice-details">
                                            <h3 class="text-uppercase">DIAGNOSIS #DIAG-0{C_ID}</h3>
                                            <ul class="list-unstyled">
                                                <li>Date: <span>{DATE}</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-lg-6 m-b-20">

                      <span>Diagnosis to:</span>
                      <ul class="list-unstyled" style="float:left;">
                        <li>
                          <h5><strong>{TO_NAME}</strong></h5>
                        </li>
                        <li>{ADDRESS}</li>
                        <li>{LGA}, {STATE}</li>
                        <li>Nigeria</li>
                        <li>{TEL}</li>
                        <li><a href="#">{TO_EMAIL}</a></li>
                      </ul>

                                    </div>
                                    <div class="col-6 col-lg-6 m-b-20">
                    <div class="invoices-view">
                      <span class="text-muted">OTher Details:</span>
                      <ul class="list-unstyled invoice-payment-details" style="float:right;">

                        <li>Department: <span>{DEPT}</span></li>
                        <li>Country: <span>Nigeria</span></li>
                        <li>State: <span>{STATE}</span></li>
                        <li>Address: <span>{ADDRESS}</span></li>
                      </ul>
                    </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="row invoice-payment">
                                        <div class="col-7">
                                        </div>
                                        <div class="col-5">
                                            <div class="m-b-20">
                                                <div class="table-responsive no-border">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th>Diagnosis:</th>
                                                                <td class="text-right">{DIAGNOSIS}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-info">
                                        <h5>Advice</h5>
                                        {ADVICE}
                                    </div>
                                </div>
                            </div>
                        </div>
                      </center>
                  </div>
              </div>
            </div>
<center> <a href="{CUSTOM_URL}" class="btn btn-primary">View in Site</a> </center>
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
</body>


<!-- invoice-view24:07-->
</html>
