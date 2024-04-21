/**
 * Call 'submit' method on /admin/faux page
 * when changed amount of items displayed per page
 */

const perPage = document.getElementById('per_page');

perPage.addEventListener('change', function () {
    const form = document.getElementById('groups_form');

    form.submit();
});
