class CreateUserPanel extends Panel {
  constructor(id){
    super(id);
    this.createUserPriviledgesSelectElement = document.querySelector('#createuser-priviledges');
    this.createUserPriviledgesSelectInstance = M.FormSelect.init(
      this.createUserPriviledgesSelectElement
    );
  }

  loadFieldsData(){
    var data = {
      username: document.querySelector('#createuser-username').value,
      password: document.querySelector('#createuser-password').value,
      priviledges : document.querySelector('#createuser-priviledges').value
    };

    if(data.username.length < 3 ||
       data.password.length < 8){
         throw new InvalidUsernameOrPasswordLengthException();
    }

    return data;
  }

  submit(){
    try{
      var data = this.loadFieldsData();
    } catch (error){
      if(error instanceof InvalidUsernameOrPasswordLengthException){
        M.toast(
          {
            html : 'Username o password troppo corti!',
            classes: 'rounded'
          }
        );
      }
      return;
    }

    $.post('http://' + server_ip + ':' + server_port + server_prefix + '/routine_createuser', data, this.callbackOnSubmit);
  }

  callbackOnSubmit(data){
    try{
      var response = JSON.parse(JSON.stringify(eval("(" + data + ")")));
    } catch (error){
      M.toast({
        html: 'Messaggio di risposta dal database non compatibile!',
        classes: 'rounded'
      })
      return;
    }

    if(response.querystatus == "good"){
      M.toast({
        html: 'Nuovo utente creato correttamente!',
        classes: 'rounded'
      });

    CreateUserPanel.tableReload();

    } else if(response.querystatus == "bad"){
      M.toast({
        html: 'Utente giá esistente!',
        classes: 'rounded'
      });
    }
  }

  static tableReload(){
    $.get('http://' + server_ip + ':' + server_port + server_prefix + '/refresh_users_table', function(data){
      document.querySelector('#createuser-table').innerHTML = data;
    });
  }

  openPanel(){
    CreateUserPanel.tableReload();
    super.openPanel();
  }
}
