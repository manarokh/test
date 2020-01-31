module.exports = {
  theme: {
      extend: {
        colors: {
          'grey-light': '#F5F6F9',
          'grey' : 'rgba(0, 0, 0, 0.4)',
          'blue-own' : '#47cdff',
          'red-own' : '#E92C24',
          default : 'var(--text-default-color)', 
          accent : 'var(--text-accent-color)', 
          'accent-light' : 'var(--text-accent-light-color)' ,
          muted : 'var(--text-muted-color)', 
          'accent-dark' : 'var(--text-muted-light-color)',
          'error' : 'var(--text-error-color)',
        },
        backgroundColor : {
          page : 'var(--page-background-color)', //bg-page
          card : 'var(--card-background-color)', //bg-card
          button : 'var(--button-background-color)', //bg-button
          header : 'var(--header-background-color)', //bg-nav
          default : 'var(--default-background-color)', //bg-default
        }, 
      },
  }
  
};