describe('Perawatan', () => {

    beforeEach(() => {
        cy.login()
        cy.visit('/perawatan')
    })

    it('Menampilkan halaman perawatan', () => {

        cy.contains('Data Perawatan')
            .should('be.visible')

    })

    it('Menambah data perawatan baru', () => {

        const timestamp = Date.now()

        cy.contains('Tambah Data Perawatan')
            .click()

        cy.url()
            .should('include', '/perawatan/create')

        cy.get('#jenis_perawatan')
            .type(`Perawatan Test ${timestamp}`)

        cy.get('#tanggal_perawatan')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/perawatan')

        cy.contains(`Perawatan Test ${timestamp}`)
            .should('exist')

    })

    it('Mengubah data perawatan', () => {

        const timestamp = Date.now()

        cy.visit('/perawatan/create')

        cy.get('#jenis_perawatan')
            .type(`Perawatan Edit ${timestamp}`)

        cy.get('#tanggal_perawatan')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.contains(`Perawatan Edit ${timestamp}`)
            .parents('tr')
            .within(() => {

                cy.get('a[href*="/edit"]')
                    .click()

            })

        cy.url()
            .should('include', '/edit')

        cy.get('#jenis_perawatan')
            .clear()
            .type(`Perawatan Updated ${timestamp}`)

        cy.contains('Simpan Perubahan')
            .click()

        cy.contains(`Perawatan Updated ${timestamp}`)
            .should('exist')

    })

    it('Menghapus data perawatan', () => {

        const timestamp = Date.now()

        cy.visit('/perawatan/create')

        cy.get('#jenis_perawatan')
            .type(`Perawatan Hapus ${timestamp}`)

        cy.get('#tanggal_perawatan')
            .type('2026-06-11')

        cy.contains('Simpan')
            .click()

        cy.on('window:confirm', () => true)

        cy.contains(`Perawatan Hapus ${timestamp}`)
            .parents('tr')
            .within(() => {

                cy.get('.tombol-hapus')
                    .click()

            })

        cy.contains(`Perawatan Hapus ${timestamp}`)
            .should('not.exist')

    })

})