<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:20px">
    <a href="{{ route('rankings.global') }}"
       style="text-align:center;padding:10px 6px;border-radius:10px;font-size:12px;font-weight:700;text-decoration:none;border:1px solid;
              {{ $active === 'global' ? 'background:#00ff87;color:#0a0f1e;border-color:#00ff87' : 'background:transparent;color:#64748b;border-color:#1e2d45' }}">
        🌐 Global
    </a>
    <a href="{{ route('rankings.location') }}"
       style="text-align:center;padding:10px 6px;border-radius:10px;font-size:12px;font-weight:700;text-decoration:none;border:1px solid;
              {{ $active === 'location' ? 'background:#00ff87;color:#0a0f1e;border-color:#00ff87' : 'background:transparent;color:#64748b;border-color:#1e2d45' }}">
        📍 Kota
    </a>
    <a href="{{ route('rankings.team') }}"
       style="text-align:center;padding:10px 6px;border-radius:10px;font-size:12px;font-weight:700;text-decoration:none;border:1px solid;
              {{ $active === 'team' ? 'background:#00ff87;color:#0a0f1e;border-color:#00ff87' : 'background:transparent;color:#64748b;border-color:#1e2d45' }}">
        🏳️ Tim
    </a>
</div>