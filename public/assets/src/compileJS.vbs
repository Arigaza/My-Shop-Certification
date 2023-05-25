' Copyright SYRADEV - Kevin Fabre - 2023
' Compress MyShopUI js files

Dim objFSO, objShell
Set objFSO = CreateObject("Scripting.FileSystemObject")
Set objShell = WScript.CreateObject("WScript.Shell")

Dim sourceJS, destinationJS, uglify
sourceJS = ".\JS\"
destinationJS = "..\js\"
uglify = ".\node_modules\uglify-js\bin\uglifyjs"

For Each file in objFSO.GetFolder(sourceJS).Files
  If objFSO.GetExtensionName(file.Name) = "js" Then
    sourceFile = objFSO.GetFileName(file)
    sourceFilenoExt = objFSO.GetBaseName(sourceFile)
    'WScript.Echo "Treating " & sourceFile & ":"
    InputBox "wwww", "", "cmd /c cd " & sourceJS & " && " & uglify & " " & sourceFile & " -o " & destinationJS & sourceFilenoExt & ".min.js -c -m --comments '/Ariga/' --source-map ""root='https://www.myshop.org/assets/src/JS/',url='" & sourceFilenoExt & ".min.js.map"""
    objShell.Run "cmd /c cd " & sourceJS & " && " & uglify & " " & sourceFile & " -o " & destinationJS & sourceFilenoExt & ".min.js -c -m --comments '/Ariga/' --source-map ""root='https://www.myshop.org/assets/src/JS/',url='" & sourceFilenoExt & ".min.js.map""", 0, True
    'WScript.Echo sourceFile & " treated."
  End If
Next

WScript.Echo "----------------------------------"
WScript.Echo "JS Compression done!"
