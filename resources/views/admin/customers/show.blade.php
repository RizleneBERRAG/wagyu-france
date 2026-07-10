@extends('layouts.admin', [
    'title' => $customer->display_name . ' — CRM Wagyu France',
    'sectionLabel' => 'Fiche client',
    'pageHeading' => $customer->display_name,
    'bodyClass' => 'admin-customer-show-page'
])

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-customers.css') }}">
@endpush

@section('content')
    <header class="admin-page-heading admin-customer-show-heading">
        <div>
            <a href="{{ route('admin.customers.index') }}" class="admin-back-link">← Retour au fichier clients</a>
            <p class="admin-kicker">{{ $customer->type_label }}</p>
            <h2>{{ $customer->display_name }}</h2>
            <p>
                Fiche créée le {{ $customer->created_at->format('d/m/Y') }} ·
                première activité {{ $customer->first_contact_at?->format('d/m/Y') ?? 'non datée' }}
            </p>
        </div>
        <div class="admin-customer-heading-actions">
            <span class="admin-crm-status is-{{ $customer->relationship_status }}">{{ $customer->relationship_label }}</span>
            <a href="mailto:{{ $customer->email }}" class="admin-primary-button">Écrire au client</a>
        </div>
    </header>

    <section class="admin-stat-grid admin-customer-detail-stats">
        <article class="admin-stat-card">
            <span>CA net TTC</span>
            <strong>{{ number_format($summary['revenue_ttc'], 0, ',', ' ') }} €</strong>
            <small>Factures moins avoirs.</small>
        </article>
        <article class="admin-stat-card">
            <span>Factures</span>
            <strong>{{ $summary['invoice_count'] }}</strong>
            <small>Particuliers et professionnels.</small>
        </article>
        <article class="admin-stat-card">
            <span>Activités commerciales</span>
            <strong>{{ $summary['activity_count'] }}</strong>
            <small>{{ $summary['shop_count'] }} boutique · {{ $summary['pro_count'] }} pro · {{ $summary['contact_count'] }} contact.</small>
        </article>
        <article class="admin-stat-card {{ $summary['follow_up_due'] ? 'is-warning' : '' }}">
            <span>Prochaine relance</span>
            <strong>{{ $customer->next_follow_up_at?->format('d/m') ?? '—' }}</strong>
            <small>
                {{ $customer->next_follow_up_at
                    ? ($summary['follow_up_due'] ? 'Échéance arrivée ou dépassée.' : $customer->next_follow_up_at->format('d/m/Y à H:i'))
                    : 'Aucune relance programmée.' }}
            </small>
        </article>
    </section>

    <section class="admin-customer-profile-grid">
        <article class="admin-card admin-customer-profile-card">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Coordonnées & segmentation</p>
                    <h3>Profil client</h3>
                </div>
                <span>{{ mb_strtoupper(mb_substr($customer->display_name, 0, 1)) }}</span>
            </div>

            <form method="POST" action="{{ route('admin.customers.update', $customer) }}" class="admin-customer-profile-form">
                @csrf
                @method('PUT')

                <div class="admin-form-grid">
                    <label>
                        <span>Type de relation</span>
                        <select name="type" required>
                            @foreach($types as $value => $label)
                                <option value="{{ $value }}" @selected(old('type', $customer->type) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Statut commercial</span>
                        <select name="relationship_status" required>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('relationship_status', $customer->relationship_status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Nom complet *</span>
                        <input type="text" name="fullname" required value="{{ old('fullname', $customer->fullname) }}">
                    </label>
                    <label>
                        <span>Société</span>
                        <input type="text" name="company" value="{{ old('company', $customer->company) }}">
                    </label>
                    <label>
                        <span>Email *</span>
                        <input type="email" name="email" required value="{{ old('email', $customer->email) }}">
                    </label>
                    <label>
                        <span>Téléphone</span>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}">
                    </label>
                    <label>
                        <span>Ville</span>
                        <input type="text" name="city" value="{{ old('city', $customer->city) }}">
                    </label>
                    <label>
                        <span>Métier / profil professionnel</span>
                        <input type="text" name="professional_type" value="{{ old('professional_type', $customer->professional_type) }}" placeholder="Restaurant, boucherie, traiteur…">
                    </label>
                    <label>
                        <span>Contact préféré</span>
                        <select name="preferred_contact">
                            <option value="">Non défini</option>
                            <option value="email" @selected(old('preferred_contact', $customer->preferred_contact) === 'email')>Email</option>
                            <option value="telephone" @selected(old('preferred_contact', $customer->preferred_contact) === 'telephone')>Téléphone</option>
                        </select>
                    </label>
                    <label>
                        <span>Prochaine relance</span>
                        <input type="datetime-local" name="next_follow_up_at" value="{{ old('next_follow_up_at', $customer->next_follow_up_at?->format('Y-m-d\TH:i')) }}">
                    </label>
                    <label class="is-wide">
                        <span>Tags, séparés par des virgules</span>
                        <input type="text" name="tags" value="{{ old('tags', implode(', ', $customer->tags ?? [])) }}" placeholder="restaurant, lyon, gros volume, presse…">
                    </label>
                    <label class="is-wide">
                        <span>Notes permanentes sur le client</span>
                        <textarea name="internal_notes" rows="5" placeholder="Préférences, contraintes, historique important…">{{ old('internal_notes', $customer->internal_notes) }}</textarea>
                    </label>
                    <label class="is-wide admin-consent-field">
                        <input type="checkbox" name="marketing_opt_in" value="1" @checked(old('marketing_opt_in', $customer->marketing_opt_in))>
                        <span>
                            Consentement marketing explicitement obtenu
                            <small>À cocher uniquement lorsqu’une preuve de consentement existe. Une simple commande ne vaut pas consentement publicitaire.</small>
                        </span>
                    </label>
                </div>

                <button type="submit" class="admin-primary-button">Enregistrer la fiche</button>
            </form>
        </article>

        <aside class="admin-customer-side-column">
            <article class="admin-card admin-customer-contact-card">
                <p class="admin-kicker">Contact rapide</p>
                <h3>{{ $customer->fullname }}</h3>
                @if($customer->company)
                    <strong>{{ $customer->company }}</strong>
                @endif
                <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                @if($customer->phone)
                    <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                @endif
                <span>{{ $customer->city ?: 'Ville non renseignée' }}</span>

                @if($customer->tags)
                    <div class="admin-customer-tags">
                        @foreach($customer->tags as $tag)
                            <span>{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </article>

            <article class="admin-card admin-customer-followup-card {{ $summary['follow_up_due'] ? 'is-due' : '' }}">
                <p class="admin-kicker">Suivi commercial</p>
                <h3>{{ $customer->next_follow_up_at ? 'Relance programmée' : 'Aucune relance' }}</h3>
                @if($customer->next_follow_up_at)
                    <strong>{{ $customer->next_follow_up_at->format('d/m/Y à H:i') }}</strong>
                    <p>{{ $summary['follow_up_due'] ? 'Cette relance demande votre attention.' : 'Elle apparaîtra automatiquement dans les alertes du tableau de bord.' }}</p>
                @else
                    <p>Ajoutez une interaction avec une échéance pour programmer automatiquement une relance.</p>
                @endif
                <small>Dernier contact enregistré : {{ $customer->last_contacted_at?->format('d/m/Y à H:i') ?? 'aucun' }}</small>
            </article>
        </aside>
    </section>

    <section class="admin-customer-history-grid">
        <article class="admin-card admin-customer-interaction-form-card">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Journal commercial</p>
                    <h3>Ajouter une interaction</h3>
                </div>
                <span>+</span>
            </div>

            <form method="POST" action="{{ route('admin.customers.interactions.store', $customer) }}" class="admin-customer-interaction-form">
                @csrf
                <div class="admin-form-grid">
                    <label>
                        <span>Type</span>
                        <select name="type" required>
                            @foreach($interactionTypes as $value => $label)
                                <option value="{{ $value }}" @selected(old('type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label>
                        <span>Date de l’échange</span>
                        <input type="datetime-local" name="happened_at" value="{{ old('happened_at', now()->format('Y-m-d\TH:i')) }}">
                    </label>
                    <label class="is-wide">
                        <span>Titre</span>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="Appel sur la prochaine découpe, demande de tarif…">
                    </label>
                    <label class="is-wide">
                        <span>Compte rendu *</span>
                        <textarea name="body" rows="5" required placeholder="Ce qui a été dit, décidé ou à retenir…">{{ old('body') }}</textarea>
                    </label>
                    <label class="is-wide">
                        <span>Échéance de relance</span>
                        <input type="datetime-local" name="due_at" value="{{ old('due_at') }}">
                        <small>Laisser vide lorsqu’aucune action future n’est nécessaire.</small>
                    </label>
                </div>
                <button type="submit" class="admin-primary-button">Ajouter à l’historique</button>
            </form>
        </article>

        <article class="admin-card admin-customer-timeline-card">
            <div class="admin-panel-heading">
                <div>
                    <p class="admin-kicker">Vue 360°</p>
                    <h3>Historique consolidé</h3>
                </div>
                <span>{{ $timeline->count() }}</span>
            </div>

            <div class="admin-customer-timeline">
                @forelse($timeline as $event)
                    <div class="admin-customer-timeline-item is-{{ $event['kind'] }}">
                        <i></i>
                        <div class="admin-customer-timeline-content">
                            <header>
                                <div>
                                    <span>{{ $event['label'] }}</span>
                                    <strong>{{ $event['title'] }}</strong>
                                </div>
                                <time>{{ $event['date']?->format('d/m/Y à H:i') }}</time>
                            </header>
                            <p>{{ $event['description'] }}</p>
                            <footer>
                                @if($event['amount'] !== null)
                                    <b>{{ number_format($event['amount'], 2, ',', ' ') }} €{{ $event['kind'] === 'pro' ? ' HT' : '' }}</b>
                                @endif
                                @if($event['route'])
                                    <a href="{{ $event['route'] }}">Ouvrir le dossier →</a>
                                @endif
                                @if(isset($event['interaction']) && $event['interaction']->due_at)
                                    <span class="admin-timeline-due {{ !$event['interaction']->completed_at && $event['interaction']->due_at->isPast() ? 'is-overdue' : '' }}">
                                        Relance : {{ $event['interaction']->due_at->format('d/m/Y à H:i') }}
                                        {{ $event['interaction']->completed_at ? '· effectuée' : '' }}
                                    </span>
                                    @unless($event['interaction']->completed_at)
                                        <form method="POST" action="{{ route('admin.customers.interactions.complete', [$customer, $event['interaction']]) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit">Marquer effectuée</button>
                                        </form>
                                    @endunless
                                @endif
                            </footer>
                        </div>
                    </div>
                @empty
                    <div class="admin-empty-state">Aucune activité n’est encore rattachée à cette fiche.</div>
                @endforelse
            </div>
        </article>
    </section>
@endsection
