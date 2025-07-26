// document.addEventListener("DOMContentLoaded", function () {
//     let activeNavLink = document.querySelector(".sidebar-nav .nav-link.active");
//     if (activeNavLink) {
//         activeNavLink.scrollIntoView({ behavior: "smooth", block: "center" });
//     }
// });
document.addEventListener("DOMContentLoaded", function () {
    // Fungsi untuk memindahkan viewport ke elemen aktif
    function scrollToActiveNavLink() {
        const activeNavLink = document.querySelector(".sidebar-nav .nav-link.active");

        if (activeNavLink) {
            // console.log("Active nav link found:", activeNavLink);

            // Gunakan setTimeout untuk memastikan DOM sepenuhnya siap
            setTimeout(() => {
                try {
                    // Scroll ke elemen aktif dengan animasi smooth
                    activeNavLink.scrollIntoView({
                        behavior: "smooth",
                        block: "center"
                    });
                } catch (error) {
                    // Fallback jika browser tidak mendukung smooth scrolling
                    console.warn("Smooth scrolling not supported, using fallback.");
                    activeNavLink.scrollIntoView(false); // Non-smooth scrolling
                }
            }, 100); // Delay 100ms untuk memastikan rendering selesai
        } else {
            // console.warn("No active nav link found.");
        }
    }

    // Panggil fungsi pertama kali saat DOM selesai dimuat
    scrollToActiveNavLink();

    // Tangani perubahan dinamis pada navigasi (opsional)
    const observer = new MutationObserver((mutationsList) => {
        for (const mutation of mutationsList) {
            if (mutation.type === "attributes" && mutation.attributeName === "class") {
                scrollToActiveNavLink();
            }
        }
    });

    // Observasi elemen sidebar-nav untuk perubahan kelas
    const sidebarNav = document.querySelector(".sidebar-nav");
    if (sidebarNav) {
        observer.observe(sidebarNav, { attributes: true, subtree: true });
    }
});



$.noConflict();
jQuery(document).ready(function ($) {
    $(".datatable").DataTable({
        dom: `
              <"row"
                  <"col-sm-12 col-md-4"B>
                  <"col-sm-12 col-md-4"l>
                  <"col-sm-12 col-md-4"f>
              >
              <"row"
                  <"col-sm-12"t>
              >
              <"row"
                  <"col-sm-12 col-md-6"i>
                  <"col-sm-12 col-md-6"p>
              >`,
        buttons: [
            {
                extend: "copy",
                text: '<i class="bi bi-clipboard"></i>',
                titleAttr: 'Copy to clipboard',
                exportOptions: {
                    columns: ":not(#export-none)",
                },
            },
            {
                extend: "csv",
                text: '<i class="bi bi-filetype-csv"></i>',
                titleAttr: 'Export to CSV',
                exportOptions: {
                    columns: ":not(#export-none)",
                },
            },
            {
                extend: "excel",
                text: '<i class="bi bi-file-earmark-excel"></i>',
                titleAttr: 'Export to Excel',
                exportOptions: {
                    columns: ":not(#export-none)",
                },
            },
            {
                extend: "pdf",
                text: '<i class="bi bi-filetype-pdf"></i>',
                titleAttr: 'Export to PDF',
                exportOptions: {
                    columns: ":not(#export-none)",
                },
            },
            {
                extend: "print",
                text: '<i class="bi bi-printer"></i>',
                titleAttr: 'Print table',
                exportOptions: {
                    columns: ":not(#export-none)",
                },
            },
        ],
        responsive: true,
        initComplete: function () {
            // Menambahkan ID ke setiap elemen dengan kelas 'row'
            $('.row').each(function (index) {
                $(this).attr('id', 'row-' + index);
            });
            // Memberikan ID pada elemen DOM lainnya
            $('.dt-buttons').attr('id', 'B'); // ID untuk tombol (B)
            $('.dataTables_length').attr('id', 'l'); // ID untuk length menu (l)
            $('.dataTables_filter').attr('id', 'f'); // ID untuk filter (f)
            $('.dataTables_info').attr('id', 'i'); // ID untuk info (i)
            $('.dataTables_paginate').attr('id', 'p'); // ID untuk pagination (p)

            // Inisialisasi tooltip untuk tombol ekspor
            const tooltipTriggerList = document.querySelectorAll('[title]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        }
    });
});

