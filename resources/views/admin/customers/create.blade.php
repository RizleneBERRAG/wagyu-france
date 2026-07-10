@extends('layouts.admin', [
    'title' => 'Nouveau contact CRM — Wagyu France',
    'sectionLabel' => 'Clients & CRM',
    'pageHeading' => 'Nouveau contact',
    'bodyClass' => 'admin-customer-create-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-customers.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-customer-create.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading admin-customer-show-heading">
        <div>
            <a href="{{ route('admin.customers.index') }}" class="admin-back-link">← Retour au fichier clients</a>
            <p class="admin-kicker">Ajout manuel</p>
            <h2>Créer une fiche avant même la première commande.</h2>
            <p>Ajoutez un prospect, un professionnel ou un partenaire rencontré hors du site.</p>
        </div>
    </header>

    <section class="admin-customer-create-layout">
        <article class="admin-card admin-customer-profile-card">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Nouvelle relation</p>
                    <h3>Informations du contact</h3>
                </div>
                <span>+</span>
            </div>

            <form method="POST" action="{{ route('admin.customers.store') }}" class="admin-customer-profile-form">
                @csrf

                <div class="admin-form-grid">
                    <label>
                        <span>Type de relation *</span>
                        <select name="type" required>
                            @foreach($types as $value => $label)
                                <option value="{{ $value }}" @selected(old('type', 'individual') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Statut commercial *</span>
                        <select name="relationship_status" required>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('relationship_status', 'prospect') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Nom complet *</span>
                        <input type="text" name="fullname" required value="{{ old('fullname') }}">
                    </label>
                    <label>
                        <span>Société</span>
                        <input type="text" name="company" value="{{ old('company') }}">
                    </label>
                    <label>
                        <span>Email *</span>
                        <input type="email" name="email" required value="{{ old('email') }}">
                    </label>
                    <label>
                        <span>Téléphone</span>
                        <input type="text" name="phone" value="{{ old('phone') }}">
                    </label>
                    <label>
                        <span>Ville</span>
                        <input type="text" name="city" value="{{ old('city') }}">
                    </label>
                    <label>
                        <span>Métier / profil professionnel</span>
                        <input type="text" name="professional_type" value="{{ old('professional_type') }}" placeholder="Restaurant, boucherie, traiteur…">
                    </label>
                    <label>
                        <span>Contact préféré</span>
                        <select name="preferred_contact">
                            <option value="">Non défini</option>
                            <option value="email" @selected(old('preferred_contact') === 'email')>Email</option>
                            <option value="telephone" @selected(old('preferred_contact') === 'telephone')>Téléphone</option>
                        </select>
                    </label>
                    <label>
                        <span>Première relance prévue</span>
                        <input type="datetime-local" name="next_follow_up_at" value="{{ old('next_follow_up_at') }}">
                    </label>
                    <label class="is-wide">
                        <span>Tags, séparés par des virgules</span>
                        <input type="text" name="tags" value="{{ old('tags') }}" placeholder="salon, restaurant, gros volume, presse…">
                    </label>
                    <label class="is-wide">
                        <span>Notes internes</span>
                        <textarea name="internal_notes" rows="5" placeholder="Contexte de la rencontre, besoin exprimé, prochaine étape…">{{ old('internal_notes') }}</textarea>
                    </label>
                    <label class="is-wide admin-consent-field">
                        <input type="checkbox" name="marketing_opt_in" value="1" @checked(old('marketing_opt_in'))>
                        <span>
                            Consentement marketing explicitement obtenu
                            <small>Ne cocher que si le contact a réellement accepté de recevoir des communications commerciales.</small>
                        </span>
                    </label>
                </div>

                <button type="submit" class="admin-primary-button">Créer la fiche client</button>
            </form>
        </article>

        <aside class="admin-card admin-customer-create-help">
            <p class="admin-kicker">Bon usage du CRM</p>
            <h3>Une fiche par adresse email.</h3>
            <p>
                Lorsqu’un contact utilisera ensuite la boutique, la réserve professionnelle ou le formulaire général
                avec cette même adresse, son activité sera automatiquement rattachée à cette fiche.
            </p>
            <ul>
                <li>Utilisez les tags pour segmenter les profils.</li>
                <li>Programmez une relance pour la faire remonter dans le cockpit.</li>
                <li>Ne cochez le consentement marketing qu’avec une preuve réelle.</li>
            </ul>
        </aside>
    </section>
@endsection
