@php
    $isShop = $documentKind === 'shop';
    $displayName = $isShop ? $documentable->fullname : $documentable->company;
    $updateRoute = $isShop
        ? route('admin.logistics.shop.update', $documentable)
        : route('admin.logistics.pro.update', $documentable);
    $documentRoute = $isShop
        ? route('admin.documents.shop.show', $documentable)
        : route('admin.documents.pro.show', $documentable);
    $preparationPdfRoute = $isShop
        ? route('admin.documents.shop.pdf', [$documentable, 'preparation'])
        : route('admin.documents.pro.pdf', [$documentable, 'preparation']);
@endphp

<article class="admin-logistics-card">
    <div class="admin-logistics-card-head">
        <div>
            <span class="admin-request-type">{{ $isShop ? 'Particulier' : 'Professionnel' }}</span>
            <h4>{{ $displayName }}</h4>
            <code>{{ $documentable->reference }}</code>
        </div>
        @unless($isShop)
            <small>{{ $documentable->bovin_reference }}</small>
        @endunless
    </div>

    <div class="admin-logistics-card-meta">
        <div>
            <span>Date prévue</span>
            <strong>{{ $documentable->scheduled_at?->format('d/m/Y H:i') ?? 'À planifier' }}</strong>
        </div>
        <div>
            <span>Mode</span>
            <strong>{{ $deliveryMethods[$documentable->delivery_method] ?? 'À définir' }}</strong>
        </div>
    </div>

    @if($documentable->tracking_number || $documentable->carrier)
        <div class="admin-logistics-tracking">
            <span>{{ $documentable->carrier ?: 'Transport' }}</span>
            <strong>{{ $documentable->tracking_number ?: 'Suivi non renseigné' }}</strong>
        </div>
    @endif

    <details class="admin-logistics-editor">
        <summary>Mettre à jour le suivi</summary>
        <form method="POST" action="{{ $updateRoute }}">
            @csrf
            @method('PUT')

            <label>
                <span>Étape actuelle</span>
                <select name="preparation_status" required>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(($documentable->preparation_status ?: 'pending') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label>
                <span>Mode de remise</span>
                <select name="delivery_method">
                    <option value="">À définir</option>
                    @foreach($deliveryMethods as $value => $label)
                        <option value="{{ $value }}" @selected($documentable->delivery_method === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label>
                <span>Date et heure prévues</span>
                <input type="datetime-local" name="scheduled_at" value="{{ $documentable->scheduled_at?->format('Y-m-d\TH:i') }}">
            </label>

            <div class="admin-logistics-form-grid">
                <label>
                    <span>Transporteur</span>
                    <input type="text" name="carrier" maxlength="190" value="{{ $documentable->carrier }}" placeholder="Chronofresh, remise directe...">
                </label>
                <label>
                    <span>Numéro de suivi</span>
                    <input type="text" name="tracking_number" maxlength="190" value="{{ $documentable->tracking_number }}">
                </label>
            </div>

            <label>
                <span>Notes logistiques</span>
                <textarea name="logistics_notes" rows="3" maxlength="3000" placeholder="Conditionnement, créneau, consigne de retrait...">{{ $documentable->logistics_notes }}</textarea>
            </label>

            <button type="submit" class="admin-primary-button">Enregistrer et notifier</button>
        </form>
    </details>

    <div class="admin-logistics-card-actions">
        <a href="{{ $documentRoute }}">Ouvrir le dossier</a>
        <a href="{{ $preparationPdfRoute }}">Bon de préparation</a>
    </div>
</article>
