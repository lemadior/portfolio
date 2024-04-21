<footer class="footer" id="footer">
    <div class="footer__left">
        <p>© 2024. All rights reserved</p>
    </div>

    <div class="footer__middle">
        <a href="{{ route('faux.groups') }}">Find Groups</a>
        <a href="{{ route('faux.students') }}">Find students</a>
        <a href="{{ route('admin.faux.index') }}">Manage</a>
        <a href="{{ url('/api/v1/documentation') }}">API</a>
    </div>

    <div class="footer__right">
        <p>University Students Database</p>
    </div>
</footer>
