describe('Penggajian - Positive', () => {

    beforeEach(() => {
        cy.login()
        cy.visit('/penggajian')
    })

    it('Menampilkan halaman penggajian', () => {

        cy.contains('Data Penggajian Karyawan')
            .should('be.visible')

    })

    it('Menambah data penggajian baru', () => {

        const nominalGaji = 5000000

        cy.contains('Tambah Data Penggajian')
            .click()

        cy.url()
            .should('include', '/penggajian/create')

        // pilih karyawan pertama selain placeholder
        cy.get('#user_id')
            .find('option')
            .eq(1)
            .then(($option) => {

                const namaKaryawan = $option.text()

                cy.wrap(namaKaryawan).as('namaKaryawan')

                cy.get('#user_id')
                    .select($option.val())

            })

        cy.get('#gaji')
            .type(nominalGaji.toString())

        cy.get('#tanggal_gaji')
            .type('2026-06-11')

        cy.get('#keterangan')
            .type('Penggajian Cypress Test')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/penggajian')

        cy.get('@namaKaryawan').then((namaKaryawan) => {

            cy.contains('td', namaKaryawan)
                .should('exist')

        })

    })

    it('Mengubah data penggajian', () => {

        const nominalAwal = 4000000
        const nominalBaru = 6500000

        cy.visit('/penggajian/create')

        cy.get('#user_id')
            .select(1)

        cy.get('#gaji')
            .type(nominalAwal.toString())

        cy.get('#tanggal_gaji')
            .type('2026-06-11')

        cy.get('#keterangan')
            .type('Data Edit Cypress')

        cy.contains('Simpan')
            .click()

        cy.get('a[href*="/penggajian/"][href*="/edit"]')
            .last()
            .click()

        cy.url()
            .should('include', '/edit')

        cy.get('#gaji')
            .clear()
            .type(nominalBaru.toString())

        cy.get('#status')
            .select('paid')

        cy.get('#keterangan')
            .clear()
            .type('Data Berhasil Diupdate')

        cy.contains('Update')
            .click()

        cy.url()
            .should('include', '/penggajian')

        cy.contains('Dibayar')
            .should('exist')

    })

    it('Menghapus data penggajian', () => {

        cy.visit('/penggajian/create')

        cy.get('#user_id')
            .select(1)

        cy.get('#gaji')
            .type('3000000')

        cy.get('#tanggal_gaji')
            .type('2026-06-11')

        cy.get('#keterangan')
            .type('Data Hapus Cypress')

        cy.contains('Simpan')
            .click()

        cy.on('window:confirm', () => true)

        cy.get('.tombol-hapus')
            .last()
            .click()

    })

})

describe('Penggajian - Negative', () => {

    beforeEach(() => {
        cy.login()
        cy.visit('/penggajian')
    })

    it('Menampilkan halaman penggajian', () => {

        cy.contains('Data Penggajian Karyawan')
            .should('be.visible')

    })

    it('Gagal menambah penggajian tanpa memilih karyawan', () => {

    cy.contains('Tambah Data Penggajian')
        .click()

    cy.get('#gaji')
        .type('500000')

    cy.get('#tanggal_gaji')
        .type('2026-06-12')

    cy.contains('Simpan')
        .click()

    cy.get('#user_id:invalid')
        .should('exist')

    })

    it('Gagal menambah penggajian jika gaji kosong', () => {

    cy.contains('Tambah Data Penggajian')
        .click()

    cy.get('#user_id')
        .select(1)

    cy.get('#tanggal_gaji')
        .type('2026-06-12')

    cy.contains('Simpan')
        .click()

    cy.get('#gaji:invalid')
        .should('exist')

    })

    it('Gagal menambah penggajian dengan nilai gaji negatif', () => {

    cy.contains('Tambah Data Penggajian')
        .click()

    cy.get('#user_id')
        .select(1)

    cy.get('#gaji')
        .type('-1000')

    cy.get('#tanggal_gaji')
        .type('2026-06-12')

    cy.contains('Simpan')
        .click()

    cy.url()
        .should('include', '/create')

    })


})