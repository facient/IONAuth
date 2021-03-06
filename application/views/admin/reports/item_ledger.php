
<!-- Start My Page Content -->
<div class="page-content">
          <div class="header">
            <h4><strong>Item Ledger Report</strong></h4>
            <div class="breadcrumb-wrapper">
              <ol class="breadcrumb">
                <li><a href="/admin">Dashboard</a>
                </li>
                <li><a href="/admin/reports">Report</a>
                </li>
                <li class="active">Item Ledger</li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 portlets">
              <div class="panel">
                <div class="panel-header">
                <div class="row">
                <div class="col-sm-2"></div>
                  <div class="col-sm-8">                  
                    <div class="plan-header bg-primary">
                      <div class="title"><h2 id="openBody">Initial Balance:&nbsp; &nbsp;<?php echo (isset($openingBal))?  $openingBal: null; ?></h2></div>                      
                                           
                    </div>
                  </div>
                <div class="col-sm-2"></div>    
                </div>
               <div class="alert alert-danger flashdelete" style="display:none"></div>
                  <form id="validateForm" action="#" method="POST" class="form-validation" novalidate="novalidate">
                  <div class="row">
                    <div class="col-sm-4">
                       <label class="form-label">Date Range</label>
                        <div class="input-daterange b-datepicker input-group" id="datepicker">
                            <input type="text"  class="input-md form-control"  id="inputStartDate" name="inputStartDate" placeholder="From..." value="<?php echo date('01-m-Y'); ?>" />
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-md form-control" id="inputEndDate" name="inputEndDate" placeholder="To ..." value="<?php echo date('t-m-Y'); ?>" />
                        </div>  
                    </div>
                    <div class="col-sm-2">                      
                      <div class="form-group">
                        <?php $items=$this->productlist->view_all(); ?>                       
                        <label class="control-label">Item</label>
                        <div class="option-group">
                            <select data-search="true" class="form-control" id="inputItem" name="inputItem" required>
                               <option value="">Select Item</option>
                              <?php foreach ($items as $item): ?>
                               <option value="<?php echo $item->id; ?>" <?php echo($item->id=='1')?'selected':null; ?>><?php echo $item->name; ?></option>
                                <?php endforeach ?>
                           </select>
                       </div>
                      </div>   
                    </div>                                         
                    <div class="col-sm-2">
                      <div class="form-group">
                          <label class="control-label">User</label>
                          <div class="append-icon">
                            <input type="text" name="inputUser" id="inputUser"  class="form-control"  placeholder="" >
                            <i class="icon-user"></i>
                          </div>
                        </div>
                    </div>
                     <div class="col-sm-2">
                      <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <br>
                        <button type="submit" id ="searchBtnItemLedger" class="btn btn-embossed btn-primary">Search</button>
                      </div>
                    </div>
                  </div>
                </form>  
                </div>
                <div class="panel-content">
                <div class="filter-left">
                  
                  <table class="table table-reponsive" id="mydatatable2">
                    <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Date</th>                                
                                <th>Transaction</th>                                
                                <th>Item Name</th>                                
                                <th>Item In</th>
                                <th>Item Out</th>
                                <th>Current Quantity</th>
                                <th>User</th>
                                <th>Details</th>
                               
                            </tr>
                        </thead>
                    <tbody id="reportBody">      
                        <?php $count=1;
                         if ($purchases!=false): ?>
                            <?php $balance=$openingBal; ?>
                            <?php foreach ($purchases as $purchase): ?>


                                <tr id="editRow">
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $purchase->mini_trans_id; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($purchase->date)); ?></td>                                    
                                    <td>
                                    <?php if($purchase->transaction=='purchase'): ?>
                                    <span class="label label-primary">Purchase</span>
                                    <?php elseif($purchase->transaction=='sales'): ?>
                                    <span class="label label-success">Sale</span>                                    
                                  <?php endif; ?>
                                    </td>  
                                    
                                    <td><?php echo $purchase->item_name; ?></td>                                        
                                    <?php  if($purchase->transaction=='purchase'): ?>
                                    <td>
                                        <?php echo $purchase->pq; ?>
                                    </td>
                                    <td>
                                        
                                    </td>
                                  <?php elseif ($purchase->transaction=='sales'):  ?>
                                  <td>
                                    
                                  </td>
                                  <td>
                                        <?php echo $purchase->sq; ?>                                    
                                  </td>  
                                  <?php endif; ?>
                                  
                                    <?php if ($purchase->transaction=='purchase'): ?>
                                    <td>
                                    <?php echo $balance+=$purchase->pq; ?>                                        
                                    </td>
                                    <?php elseif ($purchase->transaction=='sales'): ?>  
                                      <td>
                                    <?php echo $balance-=$purchase->sq ; ?>                                        
                                    </td>
                                    <?php endif ?>
                                    <td><?php echo $purchase->user_id; ?></td>
                                     <td>
                                    <a name="<?php echo $purchase->mini_trans_id; ?>" 
                                    id="<?php echo $purchase->transaction; ?>" 
                                    href="#<?php echo ($purchase->transaction=='purchase')?'Details':($purchase->transaction=='sales')?'Details':
                                    ($purchase->transaction=='quotation')?'Details':'Detail'; ?>" 
                                    data-toggle="modal" class="label label-primary reportDetails">View Details</a>
                                    </td>
                                    </tr>
                               <?php $count++; ?>
                               
                           <?php endforeach; ?>
                       <?php endif; ?>

                     </tbody>
                  </table>
                  </div>
                </div>
              </div>
            </div>
          </div>         
        </div>
<!-- END My Page Content -->


<!--Start view Details -->
  <div class="modal fade" id="Details">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="modaltranstitle"></h4>
          </div>
          <div class="modal-body">
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>Item Name</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Total</th>
                         
                      </tr>
                  </thead>
                  <tbody id="addtr">
                     
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              
          </div>
      </div>
   </div>
  </div>
<!--End view Details -->

 




