class ManageGroupsPanel extends Panel {
  constructor(id){
    super(id);
    this.manageGroupsOnCreateSelectGroupTypeElement = document.querySelector('#managegroupscreate-grouptype');
    this.manageGroupsOnCreateSelectGroupTypeInstance = M.FormSelect.init(
      this.manageGroupsOnCreateSelectGroupTypeElement
    );
    this.manageGroupsOnDeleteSelectGroupNameElement = document.querySelector('#managegroupsdelete-groupname');
    this.manageGroupsOnDeleteSelectGroupNameInstance = M.FormSelect.init(
      this.manageGroupsOnDeleteSelectGroupNameElement
    );
  }

  loadFieldsCreateData(){
    var data = {
      groupname : document.querySelector('#managegroupscreate-groupname').value,
      groupdesc : document.querySelector('#managegroupscreate-groupdesc').value,
      grouptype : document.querySelector('#managegroupscreate-grouptype').value
    };

    if(data.groupname.length < 3){
         throw new GroupNameTooSmallException();
    }

    return data;
  }

  loadFieldsDeleteData(){
    var data = {

    };

    return data;
  }

  submitCreate(){
    try{
      var data = this.loadFieldsCreateData();
    } catch (error){
      if(error instanceof GroupNameTooSmallException){
        M.toast(
          {
            html : 'Criteri di input non rispettati! Il nome del gruppo deve essere di minimo 3 caratteri.',
            classes: 'rounded'
          }
        );
      }
      return;
    }

    $.post('routines/creategroup.php', data, this.callbackOnCreateSubmit);
  }

  submitDelete(){
    try{
      var data = this.loadFieldsDeleteData();
    } catch (error){
      if(error instanceof InvalidUsernameOrPasswordLengthException){
        M.toast(
          {
            html : 'Criteri di input non rispettati!',
            classes: 'rounded'
          }
        );
      }
      return;
    }

    $.post('routines/deletegroup.php', data, this.callbackOnDeleteSubmit);
  }

  callbackOnCreateSubmit(data){
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
        html: 'Nuovo gruppo creato correttamente!',
        classes: 'rounded'
      });

      // Reload table on submit
      // TODO make it a function
      $.post("components/grouptableview.php", { ajaxrefreshrequest : true }, function(data){
        document.querySelector('#managegroups-table').innerHTML = data;
      });

    } else if(response.querystatus == "bad"){
      M.toast({
        html: 'Impossibile creare il gruppo!',
        classes: 'rounded'
      });
    }
  }

  callbackOnDeleteSubmit(data){
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
        html: 'Gruppo eliminato correttamente!',
        classes: 'rounded'
      });

    } else if(response.querystatus == "bad"){
      M.toast({
        html: 'Impossibile cancellare il gruppo!',
        classes: 'rounded'
      });
    }
  }
}
