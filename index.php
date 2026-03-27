<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Exonerados Apulo</title>

    <!----Librerias y estilos------>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        /*-------Fondo---------*/
        body {
            background-color: #f0fcfc;
        }

        /*-------Efecto Vidrio Refinado---------*/
        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
            border: 1px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 10px 35px 0 rgba(1, 69, 111, 0.08);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /*-------Scrollbar Estética---------*/
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 115, 128, 0.2);
            border-radius: 10px;
        }

        /*-------DataTables Custom---------*/
        .dataTables_filter,
        .dataTables_length {
            display: none !important;
        }

        .dataTables_info {
            color: #64748b !important;
            font-size: 0.875rem !important;
        }

        .dataTables_paginate .paginate_button {
            padding: 0.4rem 1.1rem !important;
            border-radius: 14px !important;
            border: none !important;
            background: rgba(255, 255, 255, 0.6) !important;
            margin-left: 6px !important;
            font-weight: 700 !important;
            color: #007380 !important;
            transition: all 0.25s;
        }

        .dataTables_paginate .paginate_button:hover:not(.disabled) {
            background: rgba(167, 243, 208, 0.3) !important;
            color: #047857 !important;
        }

        .dataTables_paginate .paginate_button.current {
            background: #047857 !important;
            color: white !important;
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
                        "primary-azul": "#000829",
                        "primary-verde": "#002e21",
                        "accent-azul": "#7dd3fc",
                        "accent-verde": "#a7f3d0",
                    },
                    fontFamily: {
                        "body": ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
</head>

<body class="font-body antialiased">

    <main class="relative z-10 pt-16 pb-24 px-4 md:px-12 max-w-6xl mx-auto">

        <div class="mb-12 text-center md:text-left">
            <span class="inline-block bg-primary-verde/10 text-primary-verde px-5 py-1.5 rounded-full text-sm font-black tracking-widest uppercase mb-4 shadow-sm border border-primary-azul/10">
                ISTU APULO
            </span>
            <h1 class="text-4xl md:text-5xl text-[#05013B] font-black tracking-tight leading-tight">Consulta de <span class="text-primary-verde">Exonerados</span></h1>
        </div>

        <div class="relative group mb-8">
            <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-primary-azul/30 group-focus-within:text-primary-verde transition-colors text-3xl">search</span>
            </div>
            <input id="buscadorCustom"
                class="w-full glass-card rounded-2xl py-6 pl-16 pr-9 text-lg text-slate-900 placeholder:text-slate-400 outline-none border border-primary-azul focus:ring-4 focus:ring-primary-verde/15 transition-all duration-300 focus:border-white/20 shadow-xl italic"
                placeholder="Escribe un nombre o número de DUI..." type="text" autocomplete="off" />
        </div>

        <div class="glass-card rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto custom-scrollbar">
                <table id="tablaExonerados" class="w-full text-left border-collapse table-fixed">
                    <thead class="bg-primary-verde/10">
                        <tr class="text-primary-verde text-xs uppercase tracking-[0.25em] font-black">
                            <th class="w-[20%] px-10 py-6 border-b border-white/50">DUI</th>
                            <th class="w-[50%] px-10 py-6 border-b border-white/50">Nombre Completo</th>
                            <th class="w-[30%] px-10 py-6 border-b border-white/50">Comunidad</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/40">
                        <?php
                        $sql = "SELECT dui, nombre, comunidad FROM exonerados_apulo";
                        $resultado = $conexion->query($sql);

                        if ($resultado && $resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                echo '<tr class="hover:bg-accent-azul/10 transition-colors duration-200">';

                                //-------------------DUI-------------------
                                echo '<td class="px-8 py-7">';
                                echo '<span class="font-extrabold text-primary-azul text-xl tracking-tight block truncate">' . htmlspecialchars($fila['dui']) . '</span>';
                                echo '</td>';

                                //-------------------NOMBRE-------------------
                                echo '<td class="px-8 py-7">';
                                echo '<span class="font-extrabold text-primary-azul text-xl tracking-tight block truncate" title="' . htmlspecialchars($fila['nombre']) . '">' . htmlspecialchars($fila['nombre']) . '</span>';
                                echo '</td>';

                                //-------------------COMUNIDAD-------------------
                                echo '<td class="px-8 py-5">';
                                echo '<span class="font-extrabold text-primary-azul text-xl tracking-tight block truncate" title="' . htmlspecialchars($fila['comunidad']) . '">' . (!empty($fila['comunidad']) ? htmlspecialchars($fila['comunidad']) : 'No registrada') . '</span>';
                                echo '</td>';

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
                dom: 'rt<"flex flex-col md:flex-row items-center justify-between px-10 py-8 gap-4"ip>',
                order: [
                    [1, 'asc']
                ],
                pageLength: 5,
            });

            $('#buscadorCustom').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</body>

</html>