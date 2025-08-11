<?php
require '../../../main.inc.php';
header('Content-Type: application/javascript');
?>
$(document).ready(function() {
    if (window.location.pathname.includes('compta/facture/card.php')) {

        var isInternational = ($('.facture_extras_is_international input[type="checkbox"]:checked').length > 0);
        if ($('input[name="options_is_international"]:checked').length > 0) { isInternational = true; }

        if (isInternational) {
            var creationRow = $('tr.nodrag.nodrop.nohoverpair');
            var vatCell = creationRow.find('.linecolvat');
            
            if (vatCell.length > 0) {
                vatCell.empty();
                var newFieldsHTML = `
                    <div>
                        <input type="text" name="tsr_name" placeholder="Nom taxe" class="minwidth100" style="margin-bottom: 2px;" value="">
                        <input type="number" step="0.01" name="tva_tx" placeholder="Taux %" class="minwidth100" value="">
                    </div>
                `;
                vatCell.append(newFieldsHTML);
                $('#title_vat').parent().text('Taxe Spéciale');
            }

            var totalVatLabelCell = $(".tableforfield td").filter(function() {
                return $(this).text().trim() === 'Montant TVA';
            });
            if (totalVatLabelCell.length > 0) {
                totalVatLabelCell.text('Montant Taxe Spéciale');
            }
            
            $('th.linecolvat:contains("TVA")').text('Taux Taxe Spéciale');
        }
    }
});