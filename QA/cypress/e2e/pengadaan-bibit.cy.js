describe('Pengadaan Bibit', () => {

    beforeEach(() => {
        cy.login()
        cy.visit('/pengadaan_bibit')
    })

    it('Menampilkan halaman pengadaan bibit', () => {

        cy.contains('Data Pengadaan Bibit')
            .should('be.visible')

    })

    it('Menambah data pengadaan bibit baru', () => {

        const timestamp = Date.now()

        cy.contains('Tambah Data Pengadaan')
            .click()

        cy.url()
            .should('include', '/pengadaan_bibit/create')

        cy.get('#jenis_bibit')
            .type(`Cabai`)

        cy.get('#jumlah_pembelian')
            .type('300')

        cy.get('#tanggal_pembelian')
            .type('2026-06-11')

        cy.get('#harga')
            .type('500000')

        cy.contains('Simpan')
            .click()

        cy.url()
            .should('include', '/pengadaan_bibit')

        cy.contains('Cabai')
            .should('exist')
    })

    it('Mengubah data pengadaan bibit', () => {

        const timestamp = Date.now()

        cy.contains('Tambah Data Pengadaan')
            .click()

        cy.get('#jenis_bibit')
            .type(`Cabai`)

        cy.get('#jumlah_pembelian')
            .type('50')

        cy.get('#tanggal_pembelian')
            .type('2026-06-11')

        cy.get('#harga')
            .type('250000')

        cy.contains('Simpan')
            .click()

        cy.contains('Cabai')
            .parents('tr')
            .within(() => {

                cy.get('a[href*="/edit"]')
                    .click()

            })

        cy.url()
            .should('include', '/edit')

        cy.get('#jenis_bibit')
            .clear()
            .type(`Cabai Merah`)

        cy.get('#jumlah_pembelian')
            .clear()
            .type('50')

        cy.get('#harga')
            .clear()
            .type('1000000')

        cy.contains('Simpan')
            .click()

        cy.contains('Cabai Merah')
            .should('exist')
    })

    it('Menghapus data pengadaan bibit', () => {

        const timestamp = Date.now()

        cy.visit('/pengadaan_bibit/create')

        cy.get('#jenis_bibit')
            .type(`Bibit Hapus ${timestamp}`)

        cy.get('#jumlah_pembelian')
            .type('25')

        cy.get('#tanggal_pembelian')
            .type('2026-06-11')

        cy.get('#harga')
            .type('150000')

        cy.contains('Simpan')
            .click()

        cy.on('window:confirm', () => true)

        cy.contains(`Bibit Hapus ${timestamp}`)
            .parents('tr')
            .within(() => {

                cy.get('.tombol-hapus')
                    .click()

            })

        cy.contains(`Bibit Hapus ${timestamp}`)
            .should('not.exist')
    })

})