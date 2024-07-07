
<h1>Richiesta di contatto</h1>

<p> 
    
    <ul>
        <li>
            Da: {{$lead->name}} {{$lead->surname}}
        </li>
        <li>
            Email: {{$lead->email}}
        </li>
        <li>
            Messaggio: {{$lead->body}}
        </li>
        <li>
            Il: {{date_format($lead->created_at, 'd/m/Y H:i') }}
        </li>
    </ul>
  
</p>