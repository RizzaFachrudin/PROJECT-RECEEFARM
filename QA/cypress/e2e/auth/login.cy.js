describe('Login', () => {

    it('Login berhasil', () => {

        cy.visit('/sesi')

        cy.get('input[name="username"]')
            .type('admin')

        cy.get('input[name="password"]')
            .type('admin12345')

        cy.get('button[type="submit"]').click()

        cy.url().should('not.include', '/login')
    })

})