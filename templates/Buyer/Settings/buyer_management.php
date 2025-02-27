<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Setting[]|\Cake\Collection\CollectionInterface $settings
 */
?>


<style>
 
/* toggle */
.toggle-btn .input-switch{
	display: none;
}

.toggle-btn .label-switch{
	display: inline-block;
	position: relative;
}

.toggle-btn .label-switch::before,.toggle-btn .label-switch::after{
	content: "";
	display: inline-block;
	cursor: pointer;
	transition: all 0.5s;
}

.toggle-btn .label-switch::before {
    width: 3em;
    height: 1em;
    border: 1px solid #757575;
    border-radius: 4em;
    background: #888888;
}

.toggle-btn .label-switch::after {
    position: absolute;
    left: 0;
    top: -20%;
    width: 1.5em;
    height: 1.5em;
    border: 1px solid #757575;
    border-radius: 4em;
    background: #ffffff;
}

.input-switch:checked ~ .label-switch::before {
    background: #00a900;
    border-color: #008e00;
}

.input-switch:checked ~ .label-switch::after {
    left: unset;
    right: 0;
    background: #00ce00;
    border-color: #009a00;
}

.toggle-btn .info-text {
	display: inline-block;
}

.toggle-btn .info-text::before{
	content: "In-active";
}

.input-switch:checked ~ .info-text::before{
	content: "Active";
}
.stus{
    width: 20%;
}
</style>
<?= $this->Html->css('custom') ?>
<div class="settings index content">
    
    <div class="card">
        <div class="card-header d-flex pb-2 pt-2" style="background-color:#f5f7fd">
            <div class="col-md-8">
            <div class="d-flex">
            <input type="search" placeholder="Search..." class="form-control search">
            </div>
            </div>
            <div class="col-md-4">
           <div class="d-flex justify-content-end">
              <button class="btn btn-custom mr-2 mb-0">CREATE</button>
              <button class="btn btn-custom-2 mb-0">EXPORT TO CSV</button>
           </div>
        </div>
        </div>
        
        <div class="card-body p-2">
            <div class="table-responssive">
                <table class="table table-bordered users-tbl mb-0">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Employee Code</th>
                            <th>Email</th>
                            <th class="stus">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Test Name</td>
                            <td>ABC456</td>
                            <td>test@gmail.com</td>
                            <td>
                           <div class="toggle-btn">
                           <input class='input-switch' type="checkbox" id="demo"/>
                            <label class="label-switch" for="demo"></label>
                            <span class="info-text"></span>
                           </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Test Name</td>
                            <td>ABC456</td>
                            <td>test@gmail.com</td>
                            <td>
                           <div class="toggle-btn">
                           <input class='input-switch' type="checkbox" id="demo1"/>
                            <label class="label-switch" for="demo1"></label>
                            <span class="info-text"></span>
                           </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Test Name</td>
                            <td>ABC456</td>
                            <td>test@gmail.com</td>
                            <td>
                           <div class="toggle-btn">
                           <input class='input-switch' type="checkbox" id="demo2"/>
                            <label class="label-switch" for="demo2"></label>
                            <span class="info-text"></span>
                           </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Test Name</td>
                            <td>ABC456</td>
                            <td>test@gmail.com</td>
                            <td>
                           <div class="toggle-btn">
                           <input class='input-switch' type="checkbox" id="demo3"/>
                            <label class="label-switch" for="demo3"></label>
                            <span class="info-text"></span>
                           </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
    <div class="table-responsive">
    
    </div>
</div>
