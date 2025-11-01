<?php
return '';
?>
<script>var c; setTimeout(function(){ try { c = ko.components; } catch (e) { throw "KnockoutJs not found"; } }, 2000);
function templateLoader(id) {
var t = document.querySelector('#' + tempId);
if (t !== undefined && t !== null) { return t.innerHTML; } else { return 'null'; }}
</script>
<?php $this->start('section') ?>
<div id="section" data-bind="text: name, attr: {title: name, id: name.toLowerCase()}">Section</div> <!-- ko template: { nodes: $componentTemplateNodes } --><!-- /ko -->
<script>
function section(params) { this.name = params.name; }
c.register('section', { template: templateLoader('section'), viewModel: section });
</script>
<?php $this->stop() ?>
<?php $this->start('tab') ?>
<a id="tab" class="nav-link active" data-bind="text: name, attr: {href: href, title: name, id: name.toLowerCase()}"></a>
<script>
function tab(params) { this.href = params.href; this.name = params.name; }
c.register('tab', { template: templateLoader('tab'), viewModel: tab });
</script>
<?php $this->stop() ?>
<?php $this->start('text') ?>
<input id="text" data-bind="text: name, attr: {title: name, id: name.toLowerCase(), value: value}"/>
<script>
function text(params) { this.value = params.value || ''; this.name = params.name; }
c.register('text', { template: templateLoader('text'), viewModel: text });
</script>
<?php $this->stop() ?>
<?php $this->start('number') ?>
<input id="number" type="number" data-bind="text: name, attr: {title: name, id: name.toLowerCase(), value: value}"/>
<script>
function number(params) { this.value = params.value || ''; this.name = params.name; }
c.register('number', { template: templateLoader('number'), viewModel: number });
</script>
<?php $this->stop() ?>
<?php $this->start('file') ?>
<input id="file" type="file" data-bind="text: name, attr: {title: name, id: name.toLowerCase()}"/>
<script>
function file(params) { this.value = params.value || ''; this.name = params.name; }
c.register('file', { template: templateLoader('file'), viewModel: file });
</script>
<?php $this->stop() ?>
<?php $this->start('select') ?>
<select id="select" data-bind="attr: {title: name, id: name.toLowerCase()}, options: availableOptions, selectedOptions: chosenOptions" size="5"></select>
<script>
function select(params) { this.value = params.value || ''; this.name = params.name; }
c.register('select', { template: templateLoader('select'), viewModel: select });
</script>
<?php $this->stop() ?>
<?php $this->start('multi-select') ?>
<select id="select" data-bind="attr: {title: name, id: name.toLowerCase()}, options: availableOptions, selectedOptions: chosenOptions" size="5" multiple="true"></select>
<script>
function multiSelect(params) { this.value = params.value || ''; this.name = params.name; }
c.register('multi-select', { template: templateLoader('multi-select'), viewModel: multiSelect });
</script>
<?php $this->stop() ?>
<?php $this->start('textarea') ?>
<textarea id="textarea" data-bind="text: name, attr: {title: name, id: name.toLowerCase(), value: value}"></textarea>
<script>
function textarea(params) { this.value = params.value || ''; this.name = params.name; }
c.register('textarea', { template: templateLoader('textarea'), viewModel: number });
</script>
<?php $this->stop() ?>
<?php $this->start('checkbox') ?>
<input id="checkox" type="checkox" data-bind="text: name, attr: {title: name, id: name.toLowerCase(), value: value}"/>
<script>
function checkox(params) { this.value = params.value || ''; this.name = params.name; }
c.register('checkox', { template: templateLoader('checkox'), viewModel: checkox });
</script>
<?php $this->stop() ?>
<?php $this->start('radio') ?>
<input id="checkox" type="checkox" data-bind="text: name, attr: {title: name, id: name.toLowerCase(), value: value}"/>
<script>
function checkox(params) { this.value = params.value || ''; this.name = params.name; }
c.register('checkox', { template: templateLoader('checkox'), viewModel: checkox });
</script>
<?php $this->stop() ?>
<?php $this->start('range') ?>
<input id="checkox" type="checkox" data-bind="text: name, attr: {title: name, id: name.toLowerCase(), value: value}"/>
<script>
function checkox(params) { this.value = params.value || ''; this.name = params.name; }
c.register('checkox', { template: templateLoader('checkox'), viewModel: checkox });
</script>
<?php $this->stop() ?>
<?php $this->start('button') ?>
<input id="checkox" type="checkox" data-bind="text: name, attr: {title: name, id: name.toLowerCase(), value: value}"/>
<script>
function checkox(params) { this.value = params.value || ''; this.name = params.name; }
c.register('checkox', { template: templateLoader('checkox'), viewModel: checkox });
</script>
<?php $this->stop() ?>
