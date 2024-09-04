<mjml>
    <mj-body>
      <mj-section background-color="#C1272D" background-repeat="repeat" padding="20px 0" text-align="center" vertical-align="top">
        <mj-column>
          <mj-image align="center" padding="10px 25px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSoG5WlgraUOm0pktnZswI66ISSpIm7zOQXSQ&s" width="128px"></mj-image>
        </mj-column>
      </mj-section>
      <mj-section background-color="#f0f0f0" padding="20px 0">
        <mj-column width="100%">
          <mj-text font-size="20px" color="#333333" font-family="Helvetica, Arial, sans-serif">
            Bonjour {{ $data['prenom'] }} {{ $data['nom'] }},
          </mj-text>
          <mj-text font-size="16px" color="#333333" font-family="Helvetica, Arial, sans-serif">
            Nous avons bien reçu votre demande. Voici un récapitulatif des informations :
          </mj-text>
          <mj-text font-size="16px" color="#333333" font-family="Helvetica, Arial, sans-serif">
            <strong>ID de la demande :</strong> {{ $data['demande_id'] }}<br>
            <strong>Prénom :</strong> {{ $data['prenom'] }}<br>
            <strong>Nom :</strong> {{ $data['nom'] }}<br>
            <strong>Email :</strong> {{ $data['email'] }}<br>
          </mj-text>
          <mj-divider border-color="#F45E43"></mj-divider>
          <mj-text font-size="16px" color="#333333" font-family="Helvetica, Arial, sans-serif">
            Nous vous remercions pour votre demande.
          </mj-text>
          <mj-text font-size="16px" color="#333333" font-family="Helvetica, Arial, sans-serif">
            En cas de problème, vous pouvez nous contacter à l'adresse : <strong>culture@crous-versailles.fr</strong>
          </mj-text>
          <mj-text font-size="16px" color="#333333" font-family="Helvetica, Arial, sans-serif">
            Cordialement,<br>
            Le Crous de Versailles
          </mj-text>
        </mj-column>
      </mj-section>
    </mj-body>
</mjml>
