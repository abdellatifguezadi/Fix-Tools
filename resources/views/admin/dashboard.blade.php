<x-app-layout>
    <x-slot name="title">
        Tableau de bord Admin
    </x-slot>

    <div class="p-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-stats-card 
                title="Total Utilisateurs"
                value="2,543"
                change="+12%"
                icon="users"
                color="blue"
            />

            <x-stats-card 
                title="Professionnels Actifs"
                value="847"
                change="+5%"
                icon="hard-hat"
                color="yellow"
            />

            <x-stats-card 
                title="Services Complétés"
                value="1,234"
                change="+8%"
                icon="check-circle"
                color="green"
            />

            <x-stats-card 
                title="Revenu Total"
                value="$45,678"
                change="+15%"
                icon="dollar-sign"
                color="purple"
            />
        </div>

        <!-- Tables Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Services Table -->
            <x-card title="Aperçu des Services">
                <x-table>
                    <x-slot name="header">
                        <x-table.th>Service</x-table.th>
                        <x-table.th>Total</x-table.th>
                        <x-table.th>Actif</x-table.th>
                    </x-slot>

                    <x-table.tr>
                        <x-table.td>Plomberie</x-table.td>
                        <x-table.td>450</x-table.td>
                        <x-table.td class="text-green-500">85%</x-table.td>
                    </x-table.tr>

                    <x-table.tr>
                        <x-table.td>Électricité</x-table.td>
                        <x-table.td>380</x-table.td>
                        <x-table.td class="text-green-500">78%</x-table.td>
                    </x-table.tr>

                    <x-table.tr>
                        <x-table.td>Peinture</x-table.td>
                        <x-table.td>275</x-table.td>
                        <x-table.td class="text-green-500">92%</x-table.td>
                    </x-table.tr>
                </x-table>
            </x-card>

            <!-- Revenue Table -->
            <x-card title="Revenu Mensuel">
                <x-table>
                    <x-slot name="header">
                        <x-table.th>Mois</x-table.th>
                        <x-table.th>Revenu</x-table.th>
                        <x-table.th>Croissance</x-table.th>
                    </x-slot>

                    <x-table.tr>
                        <x-table.td>Juin</x-table.td>
                        <x-table.td>$12,000</x-table.td>
                        <x-table.td class="text-green-500">+15%</x-table.td>
                    </x-table.tr>

                    <x-table.tr>
                        <x-table.td>Mai</x-table.td>
                        <x-table.td>$9,500</x-table.td>
                        <x-table.td class="text-green-500">+8%</x-table.td>
                    </x-table.tr>

                    <x-table.tr>
                        <x-table.td>Avril</x-table.td>
                        <x-table.td>$8,800</x-table.td>
                        <x-table.td class="text-red-500">-3%</x-table.td>
                    </x-table.tr>
                </x-table>
            </x-card>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Services -->
            <x-card title="Services Récents">
                <div class="space-y-4">
                    <x-activity-item
                        icon="wrench"
                        color="blue"
                        title="Réparation Plomberie"
                        subtitle="John Smith"
                        status="completed"
                    />

                    <x-activity-item
                        icon="paint-roller"
                        color="yellow"
                        title="Peinture Maison"
                        subtitle="Sarah Johnson"
                        status="in-progress"
                    />
                </div>
            </x-card>

            <!-- New Users -->
            <x-card title="Nouveaux Utilisateurs">
                <div class="space-y-4">
                    <x-user-item
                        name="Alex Johnson"
                        role="Client"
                        time="2 mins"
                        image="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde"
                    />

                    <x-user-item
                        name="Mike Brown"
                        role="Professionnel"
                        time="5 mins"
                        image="https://images.unsplash.com/photo-1540569014015-19a7be504e3a"
                    />
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout> 