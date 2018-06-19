<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="py-5" id="global">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-4">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                  <a href="" class="active nav-link" data-toggle="pill" data-target="#today">Сегодня</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="" data-toggle="pill" data-target="#tomorrow">Завтра</a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link" data-toggle="pill" data-target="#tabthree">Послезавтра</a>
                </li>
              </ul>
            </div>
            <div class="col-8">
              <div class="tab-content">
                <div class="tab-pane fade show active" id="today" role="tabpanel">
                  <table class="table table-hover table-sm">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Время</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                    <? foreach($today as $i) { ?>
                      <tr>
                        <td><?=$i['RESERVATION_NUMBER']?></td>
                        <td><?=$i['TIME']?></td>
                        <td><?=$i['SURNAME']?> <?=$i['NAME']?> <?=$i['MIDDLENAME']?></td>
                        <td><?=$i['PHONE']?></td>
                        <td><?=$i['EMAIL']?></td>
                      </tr>
                      <? } ?>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="tomorrow" role="tabpanel">
                  <table class="table table-hover table-sm">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Время</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                    <? foreach($tomorrow as $i) { ?>
                      <tr>
                        <td><?=$i['RESERVATION_NUMBER']?></td>
                        <td><?=$i['TIME']?></td>
                        <td><?=$i['SURNAME']?> <?=$i['NAME']?> <?=$i['MIDDLENAME']?></td>
                        <td><?=$i['PHONE']?></td>
                        <td><?=$i['EMAIL']?></td>
                      </tr>
                      <? } ?>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="tabthree" role="tabpanel">
                  <table class="table table-hover table-sm">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Время</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Email</th>
                      </tr>
                    </thead>
                    <tbody>
                       <? foreach($after_tomorrow as $i) { ?>
                      <tr>
                        <td><?=$i['RESERVATION_NUMBER']?></td>
                        <td><?=$i['TIME']?></td>
                        <td><?=$i['SURNAME']?> <?=$i['NAME']?> <?=$i['MIDDLENAME']?></td>
                        <td><?=$i['PHONE']?></td>
                        <td><?=$i['EMAIL']?></td>
                      </tr>
                      <? } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
