describe('Penanaman', () => {

    beforeEach(() => {
        cy.login()
        cy.visit('/penanaman')
    })

    it('Menampilkan halaman penanaman', () => {

        cy.contains('Data Penanaman')
            .should('be.visible')

    })

    it('Menambah data penanaman baru', () => {

        const timestamp = Date.now()

        cy.contains('Tambah Data Penanaman')
            .click()

        cy.url()
            .should('include', '/penanaman/create')

        cy.get('#lokasi_tanaman')
            .type(`Lahan Test ${timestamp}`)

        cy.get('#jenis_bibit')
            .type('Cabai')

        cy.get('#jumlah_bibit')
            .type('100')

        cy.get('#jumlah_tanaman')
            .type('100')

        cy.get('#tanggal_tanam')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/penanaman')

        cy.contains(`Lahan Test ${timestamp}`)
            .should('exist')
    })

    it('Mengubah data penanaman', () => {

        const timestamp = Date.now()

        cy.visit('/penanaman/create')

        cy.get('#lokasi_tanaman')
            .type(`Lahan Edit ${timestamp}`)

        cy.get('#jenis_bibit')
            .type('Tomat')

        cy.get('#jumlah_bibit')
            .type('50')

        cy.get('#jumlah_tanaman')
            .type('50')

        cy.get('#tanggal_tanam')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.contains(`Lahan Edit ${timestamp}`)
            .parents('tr')
            .within(() => {

                cy.get('a[href*="/edit"]')
                    .click()

            })

        cy.url()
            .should('include', '/edit')

        cy.get('#lokasi_tanaman')
            .clear()
            .type(`Lahan Updated ${timestamp}`)

        cy.get('#jenis_bibit')
            .clear()
            .type('Cabai Merah')

        cy.get('#jumlah_tanaman')
            .clear()
            .type('200')

        cy.contains('Simpan Perubahan')
            .click()

        cy.contains(`Lahan Updated ${timestamp}`)
            .should('exist')
    })

    it('Menghapus data penanaman', () => {

        const timestamp = Date.now()

        cy.visit('/penanaman/create')

        cy.get('#lokasi_tanaman')
            .type(`Lahan Hapus ${timestamp}`)

        cy.get('#jenis_bibit')
            .type('Terong')

        cy.get('#jumlah_bibit')
            .type('25')

        cy.get('#jumlah_tanaman')
            .type('25')

        cy.get('#tanggal_tanam')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.on('window:confirm', () => true)

        cy.contains(`Lahan Hapus ${timestamp}`)
            .parents('tr')
            .within(() => {

                cy.get('.tombol-hapus')
                    .click()

            })

        cy.contains(`Lahan Hapus ${timestamp}`)
            .should('not.exist')
    })

})