
Partial Class VB
    Inherits System.Web.UI.Page

    Protected Sub btnSubmit_Click(sender As Object, e As System.EventArgs)
        Dim dt As String = Request.Form(txtDate.UniqueID)
    End Sub
End Class
