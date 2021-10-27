<?php
/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';
include_file('core', 'authentification', 'php');
if (!isConnect()) {
  include_file('desktop', '404', 'php');
  die();
}
?>
<form class="form-horizontal">
  <fieldset>
    <div class="form-group">
      <label class="col-md-4 control-label">{{Mode}}</label>
      <div class="col-md-4">
        <select class="configKey form-control" data-l1key="mode">
          <option value="remote">{{Brocker distant}}</option>
          <option value="local">{{Brocker local}}</option>
        </select>
      </div>
    </div>
    <div class="form-group mqtt2Mode remote">
      <label class="col-md-4 control-label">{{IP}}</label>
      <div class="col-md-4">
        <input class="configKey form-control" data-l1key="remote::ip" />
      </div>
    </div>
    <div class="form-group mqtt2Mode local">
      <label class="col-md-4 control-label">{{Installer}}</label>
      <div class="col-md-4">
        <a class="btn btn-warning" id="bt_mqtt2InstallMosquitto">{{Installer mosquitto}}</a>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label">{{CA (automatiquement remplis en mode local)}}</label>
      <div class="col-md-5">
        <textarea class="configKey form-control" rows="22" data-l1key="ssl::ca"></textarea>
      </div>
    </div>
    <div class="form-group mqtt2Mode local">
      <label class="col-md-4 control-label">{{Authentification}}</label>
      <div class="col-md-5">
        <textarea class="configKey form-control" data-l1key="mqtt::password"></textarea>
      </div>
    </div>
  </fieldset>
</form>
<script>
  $('.configKey[data-l1key=mode]').off('change').on('change', function() {
    $('.mqtt2Mode').hide();
    $('.mqtt2Mode.' + $(this).value()).show();
  });

  $('#bt_mqtt2InstallMosquitto').off('click').on('click', function() {
    $.ajax({
      type: "POST",
      url: "plugins/mqtt2/core/ajax/mqtt2.ajax.php",
      data: {
        action: "installMosquitto"
      },
      dataType: 'json',
      error: function(request, status, error) {
        handleAjaxError(request, status, error);
      },
      success: function(data) {
        if (data.state != 'ok') {
          $('#div_alert').showAlert({
            message: data.result,
            level: 'danger'
          });
          return;
        } else {
          $('#div_alert').showAlert({
            message: '{{Installation lancée}}',
            level: 'success'
          });
        }
      }
    });
  });
</script>