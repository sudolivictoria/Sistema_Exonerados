<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Exonerados Apulo</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #caeff8;
            overflow-x: hidden;
        }

        /*-------Animación de Orbes de Fondo (Fluido y visible)---------*/
        @keyframes float-complex {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }

            33% {
                transform: translate(100px, -80px) scale(1.2) rotate(10deg);
            }

            66% {
                transform: translate(-60px, 120px) scale(0.9) rotate(-10deg);
            }

            100% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
        }

        .animate-float {
            animation: float-complex 10s infinite ease-in-out;
            will-change: transform;
        }

        .animation-delay-2000 {
            animation-delay: -7s;
        }

        .animation-delay-4000 {
            animation-delay: -14s;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(25px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 25px 50px -12px rgba(1, 16, 59, 0.12);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(49, 227, 104, 0.3);
            border-radius: 10px;
        }

        /*-------Styles for DataTables---------*/
        .dataTables_filter,
        .dataTables_length {
            display: none !important;
        }

        .dataTables_info {
            color: #4a5568 !important;
            font-size: 0.875rem !important;
            padding-top: 0 !important;
            font-weight: 500;
        }

        .dataTables_paginate .paginate_button {
            background: transparent !important;
            border: 1px solid transparent !important;
            color: #2d3748 !important;
            border-radius: 9999px !important;
            padding: 0.4rem 1rem !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 0.25rem !important;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .dataTables_paginate .paginate_button:hover:not(.disabled) {
            background: rgba(49, 227, 104, 0.15) !important;
            color: #31e368 !important;
        }

        .dataTables_paginate .paginate_button.current {
            background: #28c75a !important;
            color: #ffffff !important;
            border: 1px solid #31e368 !important;
            box-shadow: 0 4px 12px rgba(49, 227, 104, 0.3);
        }

        table.dataTable.no-footer {
            border-bottom: none !important;
        }
    </style>

    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#002f0f",
                        "on-surface": "#282e3e",
                        "on-surface-variant": "#01853d",
                    },
                    fontFamily: {
                        "body": ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
</head>

<body class="text-on-surface font-body min-h-screen relative selection:bg-primary/30">

    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[80%] h-[80%] bg-cyan-400/30 blur-[110px] rounded-full animate-float"></div>

        <div class="absolute top-[20%] right-[-15%] w-[60%] h-[60%] bg-primary/25 blur-[110px] rounded-full animate-float animation-delay-2000"></div>

        <div class="absolute bottom-[-15%] left-[5%] w-[50%] h-[50%] bg-blue-500/25 blur-[100px] rounded-full animate-float animation-delay-4000"></div>
    </div>

    <main class="relative z-10 pt-16 pb-20 px-4 md:px-12 max-w-7xl mx-auto">

        <div class="mb-12 space-y-8">
            <div class="space-y-1">
                <span class="bg-primary/10 text-[#01853d] px-3 py-1 rounded-full text-sm font-black tracking-widest uppercase">
                    ISTU
                </span>
                <h1 class="text-5xl text-[#01103B] font-black tracking-tighter">Apulo</h1>
                <p class="text-slate-600 font-medium italic opacity-80">Consulta de exoneraciones</p>
            </div>

            <div class="relative group w-full">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-[#01103B]/60 group-focus-within:text-[#01853d] transition-colors duration-300 text-3xl">search</span>
                </div>
                <input id="buscadorCustom"
                    class="w-full bg-white/50 backdrop-blur-[20px] saturate-[180%] 
                    border border-white/40 
                    focus:border-[#01853d] focus:ring-4 focus:ring-[#01853d]/10 
                    rounded-2xl transition-all duration-500 py-5 pl-16 pr-8 
                    text-md text-[#01103B] font-medium placeholder:text-[#01103B]/40 
                    outline-none shadow-2xl italic"
                    placeholder="Buscar exonerados por DUI o por Nombre." type="text" autocomplete="off" />
            </div>

            <div class="glass-panel rounded-3xl overflow-hidden border border-white/50">
                <div class="overflow-x-auto custom-scrollbar">

                    <table id="tablaExonerados" class="w-full text-left border-separate border-spacing-y-2 px-6 py-6">
                        <thead>
                            <tr class="text-on-surface-variant text-sm uppercase tracking-widest font-bold">
                                <th class="px-4 py-4 border-b border-primary">DUI</th>
                                <th class="px-4 py-4 border-b border-primary">Nombre Completo</th>
                            </tr>
                        </thead>
                        <tbody class="space-y-4">
                            <?php

                            $sql = "SELECT dui, nombre FROM exonerados_apulo";
                            $resultado = $conexion->query($sql);

                            if ($resultado && $resultado->num_rows > 0) {
                                while ($fila = $resultado->fetch_assoc()) {
                                    echo '<tr class="group hover:bg-white/40 transition-all duration-300">';

                                    //------dui---------->
                                    echo '<td class="px-4 py-5 rounded-l-2xl">';
                                    echo '<span class="bg-white text-primary border border-primary/20 px-3 py-1.5 rounded-lg font-mono text-sm font-bold shadow-sm inline-block tracking-widest">';
                                    echo htmlspecialchars($fila['dui']);
                                    echo '</span></td>';

                                    //-------nombre---------->
                                    echo '<td class="px-4 py-5"><span class="font-bold text-slate-900 tracking-tight text-lg">' . htmlspecialchars($fila['nombre']) . '</span></td>';

                                    //-------edad--------->
                                    echo '<td class="px-4 py-5 rounded-r-2xl"><span class="text-on-surface-variant font-mono font-bold bg-primary/5 px-3 py-1 rounded-full">' . (!empty($fila['edad']) ? htmlspecialchars($fila['edad']) . ' años' : '---') . '</span></td>';

                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#tablaExonerados').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                dom: '<"top">rt<"flex flex-col md:flex-row items-center justify-between px-8 py-6 border-t border-primary/10 gap-4"ip><"clear">',
                order: [
                    [1, 'asc']
                ],
                pageLength: 6,
                responsive: true
            });

            $('#buscadorCustom').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</body>

</html>