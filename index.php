<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html class="dark" lang="es">

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
            background-color: #041021;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-panel {
            background: rgba(13, 28, 50, 0.4);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(49, 227, 104, 0.15);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37), inset 0 0 20px rgba(49, 227, 104, 0.05);
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
            color: #bcc9c5 !important;
            font-size: 0.875rem !important;
            padding-top: 0 !important;
        }

        .dataTables_paginate .paginate_button {
            background: transparent !important;
            border: 1px solid transparent !important;
            color: #d6e3ff !important;
            border-radius: 9999px !important;
            padding: 0.4rem 1rem !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin: 0 0.25rem !important;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .dataTables_paginate .paginate_button:hover:not(.disabled) {
            background: rgba(49, 227, 104, 0.15) !important;
            color: #31e368 !important;
            border: 1px solid rgba(49, 227, 104, 0.3) !important;
        }

        .dataTables_paginate .paginate_button.current,
        .dataTables_paginate .paginate_button.current:hover {
            background: #31e368 !important;
            color: #041021 !important;
            font-weight: bold;
            border: 1px solid #31e368 !important;
            box-shadow: 0 0 12px rgba(49, 227, 104, 0.4);
        }

        .dataTables_paginate .paginate_button.disabled {
            opacity: 0.3 !important;
            cursor: default !important;
        }

        table.dataTable.no-footer {
            border-bottom: none !important;
        }
    </style>

    <!-------------Tailwind Config--------------->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#31e368",
                        "on-surface": "#d6e3ff",
                        "on-surface-variant": "#bef8e7",
                    },
                    fontFamily: {
                        "body": ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
</head>

<body class="text-on-surface font-body min-h-screen relative overflow-x-hidden selection:bg-primary/30">

    <!-----------Backgroud Effects------------>
    <div id="particles-js" class="fixed inset-0 z-0 pointer-events-none"></div>

    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-15%] left-[-10%] w-[50%] h-[50%] bg-primary/10 blur-[150px] rounded-full"></div>
        <div class="absolute bottom-[-15%] right-[-10%] w-[50%] h-[50%] bg-primary/10 blur-[150px] rounded-full"></div>
    </div>

    <main class="relative z-10 pt-20 pb-20 px-4 md:px-12 max-w-7xl mx-auto">

        <div class="mb-12 space-y-8">
            <div class="space-y-2">
                <span class="text-primary text-lg font-bold tracking-[0.2em] uppercase">ISTU</span>
                <h1 class="text-4xl md:text-5xl font-black tracking-tighter text-white">Apulo</h1>
                <p class="text-on-surface-variant max-w-xl italic">Consulta de exoneraciones en el Parque Recreativo Apulo.</p>
            </div>

            <div class="relative group w-full">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-primary text-3xl">Buscar</span>
                </div>
                <input id="buscadorCustom" class="w-full bg-[#041021]/80 backdrop-blur-md border border-primary/30 
                focus:border-primary focus:ring-2 focus:ring-primary/40 rounded-2xl transition-all duration-300 py-5 pl-16 pr-8 
                text-md text-white placeholder:text-on-surface-variant/50 outline-none shadow-lg italic" placeholder="Buscar beneficiario por DUI o por Nombre." type="text" />
            </div>
        </div>

        <div class="glass-panel rounded-2xl overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">

                <table id="tablaExonerados" class="w-full text-left border-separate border-spacing-y-2 px-6 py-4">
                    <thead>
                        <tr class="text-on-surface-variant text-sm uppercase tracking-widest font-bold">
                            <th class="px-4 py-4 border-b border-primary/20">DUI</th>
                            <th class="px-4 py-4 border-b border-primary/20">Nombre Completo</th>
                            <th class="px-4 py-4 border-b border-primary/20">Teléfono</th>
                            <th class="px-4 py-4 border-b border-primary/20">Correo Electrónico</th>
                        </tr>
                    </thead>
                    <tbody class="space-y-4">
                        <?php
                        $sql = "SELECT dui, nombre, telefono, correo FROM exonerados_apulo";
                        $resultado = $conexion->query($sql);

                        if ($resultado && $resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                echo '<tr class="group hover:bg-[rgba(49,227,104,0.05)] transition-colors duration-300 rounded-sm">';

                                //------dui---------->
                                echo '<td class="px-4 py-5 rounded-l-md">';
                                echo '<span class="bg-[#041021] text-primary border border-primary/30 px-3 py-1.5 rounded-md font-mono text-sm font-bold shadow-[0_0_10px_rgba(49,227,104,0.15)] inline-block tracking-widest">';
                                echo htmlspecialchars($fila['dui']);
                                echo '</span></td>';

                                //-------nombre---------->
                                echo '<td class="px-4 py-5"><span class="font-bold text-white tracking-tight">' . htmlspecialchars($fila['nombre']) . '</span></td>';

                                //-------telefono--------->
                                echo '<td class="px-4 py-5 text-on-surface-variant font-mono italic">' . (!empty($fila['telefono']) ? htmlspecialchars($fila['telefono']) : 'No registrado') . '</td>';

                                //--------correo--------->
                                echo '<td class="px-4 py-5 text-on-surface-variant italic rounded-r-md">' . (!empty($fila['correo']) ? htmlspecialchars($fila['correo']) : 'No registrado') . '</td>';

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
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#tablaExonerados').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    paginate: {
                        previous: 'Anterior',
                        next: 'Siguiente'
                    }
                },
                dom: '<"top">rt<"flex flex-col md:flex-row items-center justify-between px-8 py-6 border-t border-primary/10 gap-4"ip><"clear">',
                order: [
                    [1, 'asc']
                ],
                pageLength: 5
            });

            $('#buscadorCustom').on('keyup', function() {
                table.search(this.value).draw();
            });

            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 50,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#31e368"
                    },
                    "shape": {
                        "type": "circle"
                    },
                    "opacity": {
                        "value": 0.3,
                        "random": false
                    },
                    "size": {
                        "value": 2,
                        "random": true
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#31e368",
                        "opacity": 0.15,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": false
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 0.5
                            }
                        }
                    }
                },
                "retina_detect": true
            });
        });
    </script>
</body>

</html>