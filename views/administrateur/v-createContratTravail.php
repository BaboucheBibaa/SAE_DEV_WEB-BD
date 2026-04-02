
<script>
(function () {
    const employeeRole = document.getElementById('id_fonction_cree');
    const contractRole = document.getElementById('id_fonction_contrat_cree');
    const contractSwitch = document.getElementById('creer_contrat_switch');
    const contractHidden = document.getElementById('creer_contrat_cree');
    const contractBlock = document.getElementById('bloc_contrat_fields');

    function syncRole() {
        if (employeeRole && contractRole) {
            contractRole.value = employeeRole.value;
        }
    }

    function toggleContractBlock() {
        const enabled = contractSwitch && contractSwitch.checked;
        contractHidden.value = enabled ? '1' : '0';
        contractBlock.style.display = enabled ? '' : 'none';

        const inputs = contractBlock.querySelectorAll('input, select');
        inputs.forEach((input) => {
            if (input.name === 'date_debut_contrat_cree' || input.name === 'id_fonction_contrat_cree') {
                input.required = enabled;
            }
        });
    }

    if (employeeRole) {
        employeeRole.addEventListener('change', syncRole);
    }
    if (contractSwitch) {
        contractSwitch.addEventListener('change', toggleContractBlock);
    }

    syncRole();
    toggleContractBlock();
})();
</script>
