$(function() {
  $(".formgtk").validate({
    rules: {
      nama: {
        required: true,
        minlength: 3
      },
      jk: {
        required: true
      },
      tempatlahir: {
        required: true,
        minlength: 3
      },
      tgllahir: {
        required: true,
        date: true
      },
      ibukandung: {
        required: true,
        minlength: 3
      },
      alamat: {
        required: true
      },
      kelurahan: {
        required: true
      },
      kecamatan: {
        required: true
      },
      agama: {
        required: true
      },
      warganegara: {
        required: true
      },
      nik: {
        required: true
      },
      statusnikah: {
        required: true
      },
      jenisptk: {
        required: true
      },
      statuspegawai: {
        required: true
      },
      skkerja: {
        required: true
      },
      tmtkerja: {
        required: true
      },
      lembaga: {
        required: true
      },
      gaji: {
        required: true
      },
      handphone: {
        required: true,
        number: true
      },
      email: {
        required: true,
        email: true
      }
    },
    messages: {
      nama: {
        required: "Nama tidak boleh kosong",
        minlength: "Nama terlalu singkat"
      },
      jk: {
        required: "Jenis kelamin harus dipilih"
      },
      tempatlahir: {
        required: "Tempat lahir tidak boleh kosong",
        minlength: "Tempat lahir terlalu singkat"
      },
      tgllahir: {
        required: "Tanggal lahir tidak boleh kosong",
        date: "Format tanggal lahir tidak valid"
      },
      ibukandung: {
        required: "Nama ibu kandung tidak boleh kosong",
        minlength: "Nama ibu kandung terlalu singkat"
      },
      alamat: {
        required: "Alamat tidak boleh kosong"
      },
      kelurahan: {
        required: "Kelurahan tidak boleh kosong"
      },
      kecamatan: {
        required: "Kecamatan tidak boleh kosong"
      },
      agama: {
        required: "Agama harus dipilih"
      },
      warganegara: {
        required: "Kewarganegaraan harus dipilih"
      },
      nik: {
        required: "NIK harus di isi"
      },
      statusnikah: {
        required: "Status nikah harus dipilih"
      },
      jenisptk: {
        required: "Jenis PTK harus dipilih"
      },
      statuspegawai: {
        required: "Status Pegawai harus dipilih"
      },
      skkerja: {
        required: "SK Pengangkatan harus diisi"
      },
      tmtkerja: {
        required: "TMT Pengangkatan harus diisi"
      },
      lembaga: {
        required: "Lembaga pengangkatan harus dipilih"
      },
      gaji: {
        required: "Sumber gaji harus dipilih"
      },
      handphone: {
        required: "Masukkan nomor handphone",
        number: "Format handphone tidak valid"
      },
      email: {
        required: "Email harus diisi",
        email: "Format email tidak valid"
      }
    },
    errorElement: "em",
    errorPlacement: function(error, element) {
      // Add the `invalid-feedback` class to the error element
      error.addClass("invalid-feedback");
      var elem = $(element);

      if (elem.hasClass("agama")) {
        error.insertAfter($(".form-select-feedback"));
      }
      if (elem.hasClass("kecamatan")) {
        error.insertAfter($(".kecamatan-feedback"));
      }
      if (elem.hasClass("statusnikah")) {
        error.insertAfter($(".statusnikah-feedback"));
      }
      if (elem.hasClass("jenisptk")) {
        error.insertAfter($(".jenisptk-feedback"));
      }
      if (elem.hasClass("statuspegawai")) {
        error.insertAfter($(".statuspegawai-feedback"));
      }
      if (elem.hasClass("lembaga")) {
        error.insertAfter($(".lembaga-feedback"));
      }
      if (elem.hasClass("statusnikah")) {
        error.insertAfter($(".statusnikah-feedback"));
      }
      if (elem.hasClass("gaji")) {
        error.insertAfter($(".gaji-feedback"));
      }
      if (element.prop("type") === "radio") {
        error.insertAfter($(".checkbox"));
      }
      if ($(".datetimepicker-input").prop("type") === "text") {
        error.insertAfter(element.next("div"));
      } else {
        error.insertAfter(element);
      }
    },
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    }
  });

  $(".formpd").validate({
    rules: {
      satuanpendidikan: {
        required: true
      },
      nama: {
        required: true,
        minlength: 3
      },
      jk: {
        required: true
      },
      tempatlahir: {
        required: true,
        minlength: 4
      },
      tgllahir: {
        required: true,
        date: true
      },
      agama: {
        required: true
      },
      alamat: {
        required: true
      },
      kelurahan: {
        required: true
      },
      kecamatan: {
        required: true
      },
      jenistinggal: {
        required: true
      },
      transportasi: {
        required: true
      },
      namaayah: {
        required: true
      },
      pendidikanayah: {
        required: true
      },
      pekerjaanayah: {
        required: true
      },
      penghasilanayah: {
        required: true
      },
      ibukandung: {
        required: true
      },
      pendidikanibu: {
        required: true
      },
      pekerjaanibu: {
        required: true
      },
      penghasilanibu: {
        required: true
      },
      namawali: {
        required: true
      },
      pendidikanwali: {
        required: true
      },
      pekerjaanwali: {
        required: true
      },
      penghasilanwali: {
        required: true
      }
    },
    messages: {
      satuanpendidikan: {
        required: "Silahkan pilih satuan pendidikan"
      },
      nama: {
        required: "Nama tidak boleh kosong",
        minlength: "Nama terlalu singkat"
      },
      jk: {
        required: "Jenis kelamin harus dipilih"
      },
      tempatlahir: {
        required: "Tempat lahir tidak boleh kosong",
        minlength: "Tempat lahir terlalu singkat"
      },
      tgllahir: {
        required: "Tanggal lahir tidak boleh kosong",
        date: "Format tanggal lahir tidak valid"
      },
      agama: {
        required: "Agama harus dipilih"
      },
      alamat: {
        required: "Alamat tidak boleh kosong"
      },
      kelurahan: {
        required: "Kelurahan tidak boleh kosong"
      },
      kecamatan: {
        required: "Kecamatan tidak boleh kosong"
      },
      jenistinggal: {
        required: "Tempat tinggal harus dipilih"
      },
      transportasi: {
        required: "Moda transportasi harus dipilih"
      },
      namaayah: {
        required: "Nama ayah tidak boleh kosong",
        minlength: "Nama ayah terlalu singkat"
      },
      pendidikanayah: {
        required: "Pendidikan ayah harus dipilih"
      },
      pekerjaanayah: {
        required: "Pekerjaan ayah harus dipilih"
      },
      penghasilanayah: {
        required: "Penghasilan ayah harus dipilih"
      },
      ibukandung: {
        required: "Nama ibu tidak boleh kosong",
        minlength: "Nama ibu terlalu singkat"
      },
      pendidikanibu: {
        required: "Pendidikan ibu harus dipilih"
      },
      pekerjaanibu: {
        required: "Pekerjaan ibu harus dipilih"
      },
      penghasilanibu: {
        required: "Penghasilan ibu harus dipilih"
      },
      namawali: {
        required: "Nama wali tidak boleh kosong",
        minlength: "Nama wali terlalu singkat"
      },
      pendidikanwali: {
        required: "Pendidikan ibu harus dipilih"
      },
      pekerjaanwali: {
        required: "Pekerjaan ibu harus dipilih"
      },
      penghasilanwali: {
        required: "Penghasilan ibu harus dipilih"
      }
    },
    errorElement: "em",
    errorPlacement: function(error, element) {
      // Add the `invalid-feedback` class to the error element
      error.addClass("invalid-feedback");
      var elem = $(element);

      if (elem.hasClass("satuanpendidikan")) {
        error.insertAfter($(".satuanpendidikan-feedback"));
      }
      if (elem.hasClass("agama")) {
        error.insertAfter($(".form-select-feedback"));
      }
      if (elem.hasClass("kecamatan")) {
        error.insertAfter($(".kecamatan-feedback"));
      }
      if (elem.hasClass("jenis-tinggal")) {
        error.insertAfter($(".jenistinggal"));
      }
      if (elem.hasClass("transportasi")) {
        error.insertAfter($(".transportasi-feedback"));
      }
      if (elem.hasClass("pendidikanayah")) {
        error.insertAfter($(".pendidikanayah-feedback"));
      }
      if (elem.hasClass("pekerjaanayah")) {
        error.insertAfter($(".pekerjaanayah-feedback"));
      }
      if (elem.hasClass("penghasilanayah")) {
        error.insertAfter($(".penghasilanayah-feedback"));
      }
      if (elem.hasClass("pendidikanibu")) {
        error.insertAfter($(".pendidikanibu-feedback"));
      }
      if (elem.hasClass("pekerjaanibu")) {
        error.insertAfter($(".pekerjaanibu-feedback"));
      }
      if (elem.hasClass("penghasilanibu")) {
        error.insertAfter($(".penghasilanibu-feedback"));
      }
      if (elem.hasClass("pendidikanwali")) {
        error.insertAfter($(".pendidikanwali-feedback"));
      }
      if (elem.hasClass("pekerjaanwali")) {
        error.insertAfter($(".pekerjaanwali-feedback"));
      }
      if (elem.hasClass("penghasilanwali")) {
        error.insertAfter($(".penghasilanwali-feedback"));
      }
      if (element.prop("type") === "text") {
        error.insertAfter(element.next("datalist"));
      }
      if (element.prop("type") === "radio") {
        error.insertAfter($(".checkbox"));
      }
      if ($(".datetimepicker-input").prop("type") === "text") {
        error.insertAfter(element.next("div"));
      } else {
        error.insertAfter(element);
      }
    },
    highlight: function(element, errorClass, validClass) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    }
  });

  $(
    "#satuanpendidikan, #agama, #kecamatan, #jenistinggal, #transportasi, #pendidikanayah, #pekerjaanayah, #penghasilanayah, #pendidikanibu, #pekerjaanibu, #penghasilanibu, #pendidikanwali, #pekerjaanwali, #penghasilanwali #statusnikah, #jenisptk, #statuspegawai, #lembaga, #gaji"
  )
    .select2()
    .change(function() {
      $(this).valid();
    });
});
