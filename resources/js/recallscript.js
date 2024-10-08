<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener for button click
        document.getElementById('recall-data').addEventListener('click', function() {
            // Assuming $formData is available in JavaScript
            const formData = @json($formData);
    
            if (formData) {
                // Populate text inputs
                document.getElementById('project_id').value = formData.project_id || '';
                document.getElementById('inv_type').value = formData.inv_type || '';
                document.getElementById('inv_brand').value = formData.inv_brand || '';
                document.getElementById('inv_model').value = formData.inv_model || '';
                document.getElementById('inv_detail').value = formData.inv_detail || '';
                document.getElementById('inv_rtaf_serial').value = formData.inv_rtaf_serial || '';
                document.getElementById('inv_serial_number').value = formData.inv_serial_number || '';
                document.getElementById('inv_mac_address').value = formData.inv_mac_address || '';
                document.getElementById('inv_cpu').value = formData.inv_cpu || '';
                document.getElementById('inv_ram').value = formData.inv_ram || '';
                document.getElementById('inv_ram_speed').value = formData.inv_ram_speed || '';
                document.getElementById('inv_storage_type').value = formData.inv_storage_type || '';
                document.getElementById('inv_storage_size').value = formData.inv_storage_size || '';
                document.getElementById('inv_os_type').value = formData.inv_os_type || '';
                document.getElementById('inv_os_version').value = formData.inv_os_version || '';
                document.getElementById('inv_msoffice_version').value = formData.inv_msoffice_version || '';
                document.getElementById('inv_antivirus').value = formData.inv_antivirus || '';
                document.getElementById('inv_status').value = formData.inv_status || '';
                document.getElementById('inv_cpu_clock').value = formData.inv_cpu_clock || '';
    
                // Populate select fields
                const selectFields = {
                    'inv_os_copyright': formData.inv_os_copyright,
                    'inv_msoffice_copyright': formData.inv_msoffice_copyright,
                    'inv_antivirus_copyright': formData.inv_antivirus_copyright
                };
    
                for (const [id, value] of Object.entries(selectFields)) {
                    const selectField = document.getElementById(id);
                    if (selectField) {
                        selectField.value = value || '';
                    }
                }
    
                // Populate date fields
                document.getElementById('inv_setup_year').value = formData.inv_setup_year || '';
            }
        });
    });
    </script>
    